<?php

namespace App\Blackjack\BlackjackGameResults;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Blackjack\BlackjackPlayer\BlackjackPlayer;
use App\Blackjack\BlackjackPlayer\BlackjackDealer;
use App\Blackjack\BlackjackGameResults\BJGRSessionHandlingTrait;
use App\Blackjack\BlackjackGameResults\BJGRFormattingTrait;
use App\Blackjack\BlackjackGameResults\BJGRHandEvaluationTrait;
use App\Blackjack\BlackjackGameResults\BJGRHandRewardTrait;

/**
 * BlackjackGameResults-Class, containing all the necessary logic to process
 * the results from a Blackjack-round.
 */
class BlackjackGameResults
{
    use BJGRSessionHandlingTrait;
    use BJGRFormattingTrait;
    use BJGRHandEvaluationTrait;
    use BJGRHandRewardTrait;

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

}
