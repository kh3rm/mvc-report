<?php

namespace App\Card;

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
     * Check if the game has been decided..
     */
    public function checkIfGameDecided(): void
    {
        if ($this->player->getChipCount() === 0 || $this->dealer->getChipCount() === 0) {
            $this->gameDecided = true;
        }
    }


    /**
     * Getter of the boolean-value of whether the game has been decided.
     */
    public function getGameDecided(): bool
    {
        return $this->gameDecided;
    }


    public function decideBlackjackRoundResults(?BlackjackPlayer $player = null, ?BlackjackDealer $dealer = null): string {
        $player = $player ?? $this->player;
        $dealer = $dealer ?? $this->dealer;

        $dealerHandValue = $dealer->getHands()[0]->currentHandValue();

        $totalWagered = $player->getChipsInPlayCount() + $dealer->getChipsInPlayCount();

        $playerWon = 0;
        $dealerWon = 0;

        if ($dealerHandValue > 21) {
            foreach ($player->getHands() as $hand) {
                $playerHandValue = $hand->currentHandValue();

                if ($playerHandValue <= 21) {
                    $playerWon += 200;
                } else {
                    $playerWon += 100;
                    $dealerWon += 100;
                }
            }
        } else {
            foreach ($player->getHands() as $hand) {
                $playerHandValue = $hand->currentHandValue();

                if ($playerHandValue > 21) {
                    $dealerWon += 200;
                } elseif ($playerHandValue < $dealerHandValue) {
                    $dealerWon += 200;
                } elseif ($playerHandValue > $dealerHandValue) {
                    $playerWon += 200;
                } else {
                    $dealerWon += 100;
                    $playerWon += 100;
                }
            }
        }
        $player->addChips($playerWon);
        $dealer->addChips($dealerWon);

        $player->resetChipsInPlay();
        $dealer->resetChipsInPlay();

        $player->resetHands();
        $dealer->resetHands();

        $dealer->deactivateTurn();

        $this->checkIfGameDecided();

        $playerResults = $playerWon - ($totalWagered / 2);
        $dealerResults = $dealerWon - ($totalWagered / 2);

        $formattedPlayerResults = ($playerResults >= 0 ? '+' : '') . $playerResults;
        $formattedDealerResults = ($dealerResults >= 0 ? '+' : '') . $dealerResults;


        return "Round Results: Player: {$formattedPlayerResults}, Dealer: {$formattedDealerResults}\n";
    }
}