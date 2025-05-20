<?php

namespace App\Card;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class BlackjackGameResults
{
    /**
     * An array that holds the Players active.
     *
     * @var BlackjackPlayer  $player  The Player active in the game.
     */
    protected BlackjackPlayer $player;

    /**
     * A variable that holds the Dealer active in the game.
     *
     * @var BlackjackDealer  $dealer  The dealer active in the game.
     */
    protected BlackjackDealer $dealer;


    /**
     * A variable that holds a boolean-value of whether the game is complete
     * (player or dealer is out of chips).
     *
     * @var bool  $gameDecided  Game Decided? true/false.
     */
    protected bool $gameDecided = false;


    /**
     * A variable that holds the current session-state.
     *
     * @var sessionInterface  $sessionState  The session-state.
     */
    protected ?SessionInterface $sessionState = null;



    /**
     * Constructor that populates the class with the deck, players and dealer
     * active for the given BlackjackGame.
     *
     * @param BlackjackPlayer $player The player active in the game.
     * @param BlackjackDealer $dealer An instance of the dealer (house/computer player).
     */
    public function __construct(BlackjackPlayer $player, BlackjackDealer $dealer)
    {
        $this->player = $player;
        $this->dealer = $dealer;
    }




    /**
     * Checks if the game has been decided, and updates the gameDecided attribute
     * accordingly.
     */
    public function checkIfGameDecided(): void
    {
        if ($this->player->getChipCount() === 0 || $this->dealer->getChipCount() === 0) {
            $this->gameDecided = true;
        }
    }


    /**
     * Establishing the current session-state to enable the session-clearing method to do its job.
     * (In accordance with the principle of dependency injection.)
     */
    public function establishUpToDateSession(SessionInterface $session): void
    {
        $this->sessionState = $session;
    }

    /**
     * Get the object's sessionState.
     */
    public function getSessionState(): ?SessionInterface
    {
        return $this->sessionState;
    }



    public function clearBlackjackGameSession(): void
    {

        if ($this->sessionState instanceof SessionInterface) {
            $this->sessionState->remove("deck_in_use");
            $this->sessionState->remove("player");
            $this->sessionState->remove("dealer");
            $this->sessionState->remove("splits_afforded");
            $this->sessionState->remove("roundmsg");
            $this->sessionState->remove("game_decided");
            $this->sessionState->remove("smallest_chip_count");
            $this->sessionState->remove("maximum_hands");
            $this->sessionState->remove("game-finished-object");
            $this->sessionState->remove("current_chip_count");
            $this->sessionState->remove("current_chip_count_json");
        }
    }

    /**
     * Getter of the boolean-value of whether the game has been decided.
     */
    public function getGameDecided(): bool
    {
        return $this->gameDecided;
    }

    /**
     * Method that evaluates the hands and compiles the round results,
     * and cleans up and makes relevant checks at the end of the operation.
     *
     * @return mixed[] a mixed array with a result string for the round, the chip-count and
     * also JSON-formatted chip-count.
     */
    public function decideBlackjackRoundResults(): array
    {
        $player = $this->player;
        $dealer = $this->dealer;

        $dealerHandValue = $dealer->getHands()[0]->currentHandValue();
        $totalWagered = $player->getChipsInPlayCount() + $dealer->getChipsInPlayCount();

        [$playerWon, $dealerWon] = $this->evaluatePlayerHands($player, $dealerHandValue);

        $this->processChips($player, $dealer, $playerWon, $dealerWon);
        $this->resetGameState($player, $dealer);
        $this->checkIfGameDecided();

        return $this->formatRoundResults($player, $dealer, $playerWon, $dealerWon, $totalWagered);
    }


    /**
     * Evaluates the player's hands against the dealer's hand and calculates the wins.
     *
     * @param BlackjackPlayer $player The player object.
     * @param int $dealerHandValue The value of the dealer's hand that is currently being evaluated.
     * @return array<int, int> An array containing total chips won by the player and dealer in the current round.
     */
    private function evaluatePlayerHands($player, $dealerHandValue): array
    {
        $playerWon = 0;
        $dealerWon = 0;

        if ($dealerHandValue > 21) {
            foreach ($player->getHands() as $hand) {
                $playerHandValue = $hand->currentHandValue();
                $this->handleDealerBust($playerHandValue, $playerWon, $dealerWon);
            }
        }

        if ($dealerHandValue <= 21) {
            foreach ($player->getHands() as $hand) {
                $playerHandValue = $hand->currentHandValue();
                $this->handleDealerNotBust($playerHandValue, $dealerHandValue, $playerWon, $dealerWon);
            }
        }

        return [$playerWon, $dealerWon];
    }




    /**
      * Increments the player's winnings by 200.
      *
      * @param int $playerWon (&) Reference parameter for the player's total winnings,
      * which allows modifications to update the original variable.
      */
    private function playerWinsHand(&$playerWon): void
    {
        $playerWon += 200;
    }

    /**
     * Increments the dealer's winnings by 200.
     *
     * @param int $dealerWon (&) Reference parameter for the dealer's total winnings,
     * which allows modifications to update the original variable.
     */
    private function dealerWinsHand(&$dealerWon): void
    {
        $dealerWon += 200;
    }

    /**
     * Increments the player's and dealer's winnings by 100 each (draw).
     *
     * @param int $playerWon (&) Reference parameter for the player's total winnings,
     * which allows modifications to update the original variable.
     *
     * @param int $dealerWon (&) Reference parameter for the dealer's total winnings,
     * which allows modifications to update the original variable.
     */
    private function drawnHand(&$playerWon, &$dealerWon): void
    {
        $playerWon += 100;
        $dealerWon += 100;
    }

    /**
     * Handles the scenario where the dealer is bust.
     *
     * @param int $playerHandValue The total value of the player's hand.
     * @param int $playerWon (&) Reference parameter for the player's total winnings,
     * which allows modifications to update the original variable.
     *
     * @param int $dealerWon (&) Reference parameter for the dealer's total winnings,
     * which allows modifications to update the original variable.
     */
    private function handleDealerBust($playerHandValue, &$playerWon, &$dealerWon): void
    {
        if ($playerHandValue <= 21) {
            $this->playerWinsHand($playerWon);
        }
        if ($playerHandValue > 21) {
            $this->drawnHand($playerWon, $dealerWon);
        }
    }

    /**
     * Handles the scenarios where the dealer is not bust.
     *
     * @param int $playerHandValue The total value of the player's hand.
     * @param int $dealerHandValue The total value of the dealer's hand.
     * @param int $playerWon (&) Reference parameter for the player's total winnings,
     * which allows modifications to update the original variable.
     *
     * @param int $dealerWon (&) Reference parameter for the dealer's total winnings,
     * which allows modifications to update the original variable.
     */
    private function handleDealerNotBust($playerHandValue, $dealerHandValue, &$playerWon, &$dealerWon): void
    {
        if ($playerHandValue > 21) {
            $this->dealerWinsHand($dealerWon);
        }
        if ($playerHandValue <= 21) {
            if ($playerHandValue < $dealerHandValue) {
                $this->dealerWinsHand($dealerWon);
            }
            if ($playerHandValue > $dealerHandValue) {
                $this->playerWinsHand($playerWon);
            }
            if ($playerHandValue == $dealerHandValue) {
                $this->drawnHand($playerWon, $dealerWon);
            }
        }
    }



    /**
     * Processes the chips based on round results.
     *
     * @param BlackjackPlayer $player The player object.
     * @param BlackjackDealer $dealer The dealer object.
     * @param int $playerWon The total chips won by the player.
     * @param int $dealerWon The total chips won by the dealer.
     */
    private function processChips($player, $dealer, $playerWon, $dealerWon): void
    {
        $player->addChips($playerWon);
        $dealer->addChips($dealerWon);
    }

    /**
     * Resets the game state for the next round, clearing chips and hands.
     *
     * @param BlackjackPlayer $player The player whose state is being reset.
     * @param BlackjackDealer $dealer The dealer whose state is being reset.
     */
    private function resetGameState($player, $dealer): void
    {
        $player->resetChipsInPlay();
        $dealer->resetChipsInPlay();
        $player->resetHands();
        $dealer->resetHands();
        $dealer->deactivateTurn();
    }

    /**
     * Formats the round results into an array structure for output.
     *
     * @param BlackjackPlayer $player The player whose results are formatted.
     * @param BlackjackDealer $dealer The dealer.
     * @param int $playerWon The total chips won by the player.
     * @param int $dealerWon The total chips won by the dealer.
     * @param int $totalWagered The total amount wagered in the round.
     * @return mixed[] An array with round result strings and JSON-formatted chip counts.
     */
    private function formatRoundResults($player, $dealer, $playerWon, $dealerWon, $totalWagered): array
    {
        $playerName = $player->getPlayerName();
        $playerResults = $playerWon - ($totalWagered / 2);
        $dealerResults = $dealerWon - ($totalWagered / 2);

        return [
            "round-results" => "Round Results: $playerName: " . $this->formatResult($playerResults) .
                            ", Dealer: " . $this->formatResult($dealerResults) . ".",
            "chip-count" => "$playerName: " . $player->getChipCount() .
                            " Dealer: " . $dealer->getChipCount(),
            "chip-count-json" => [
                "$playerName" => $player->getChipCount(),
                "dealer" => $dealer->getChipCount(),
            ]
        ];
    }

    /**
     * Formats the results for display.
     *
     * @param int $results The results amount to format.
     * @return string Formatted result as a string with an initial '+' for the positive results.
     */
    private function formatResult($results): string
    {
        return ($results >= 0 ? '+' : '') . $results;
    }
}
