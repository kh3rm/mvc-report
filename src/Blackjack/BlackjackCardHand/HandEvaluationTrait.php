<?php

namespace App\Blackjack\BlackjackCardHand;

/**
 * HandEvaluation-Trait, handles the BlackjackCardHand's
 * hand evaluation.
 *
 */
trait HandEvaluationTrait
{
    /**
     * Method that calculates the current value of the blackjack hand, according to blackjack-specific
     * logic.
     *
     * @return int The total value of the cards in hand.
     */
    public function currentHandValue(): int
    {
        $totalValue = 0;
        $aceCount = 0;

        foreach ($this->cards as $card) {
            $rank = $card->getRank();

            if ($rank == 11 || $rank == 12 || $rank == 13) {
                $totalValue += 10;
            }

            if ($rank === 14) {
                $totalValue += 11;
                $aceCount++;
            }

            if ($rank < 11) {
                $totalValue += $rank;
            }
        }

        while ($totalValue > 21 && $aceCount > 0) {
            $totalValue -= 10;
            $aceCount--;
        }

        return $totalValue;
    }

}
