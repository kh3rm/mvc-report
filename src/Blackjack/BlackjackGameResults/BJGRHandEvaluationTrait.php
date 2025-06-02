<?php

namespace App\Blackjack\BlackjackGameResults;

use App\Blackjack\BlackjackPlayer\BlackjackPlayer;

/**
 * BJGRHandEvaluationTrait, containing all the hand-evaluation logic
 * relating to the BlackjackGameResults-class.
 */
trait BJGRHandEvaluationTrait
{
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
}
