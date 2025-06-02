<?php

namespace App\Blackjack\BlackjackGameResults;

/**
 * BJGRHandEvaluationTrait, containing all the hand-evaluation logic
 * relating to the BlackjackGameResults-class.
 */
trait BJGRHandRewardTrait
{
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
}
