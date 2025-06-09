<?php namespace App\PokerPatienceGS;
use App\Exception\IncorrectGridFormatException;

/**
 * Class EvaluateHands
 *
 * This class evaluates poker hands from a 5x5 grid representing a game state.
 */
trait HandScoringTrait {

    /**
     * Checks if the hand has one pair.
     *
     * @param array $values The values of the cards in the hand.
     * @return bool True if the hand contains exactly one pair, false otherwise.
     */
    private function handOnePair($values): bool {
        return count(array_unique($values)) == 4;
    }




    /**
     * Checks if the hand has two pairs.
     *
     * @param array $values The values of the cards in the hand.
     * @return bool True if the hand contains two pairs, false otherwise.
     */
    private function handTwoPairs($values): bool {
        $counts = array_count_values($values);
        return count($counts) == 3 && count(array_filter($counts, fn($c) => $c == 2)) == 2;
    }



    /**
     * Checks if the hand has three of a kind.
     *
     * @param array $values The values of the cards in the hand.
     * @return bool True if the hand contains three of a kind, false otherwise.
     */
    private function handThreeOfAKind($values): bool {
        return count(array_unique($values)) == 3 && max(array_count_values($values)) == 3;
    }



    /**
     * Checks if the hand is a straight.
     *
     * @param array $values The values of the cards in the hand.
     * @return bool True if the hand is a straight, false otherwise.
     */
    private function handStraight($values): bool {
        $uniqueValues = array_unique($values);
        sort($uniqueValues);

        if (count($uniqueValues) < 5) {
            return false;
        }

        if ($uniqueValues[4] - $uniqueValues[0] == 4 && count($uniqueValues) == 5) {
            return true;
        }

        if ($uniqueValues === [2, 3, 4, 5, 14]) {
            return true; // Special case for Ace-low straight
        }

        return false;
    }



    /**
     * Checks if the hand is a flush.
     *
     * @param array $suits The suits of the cards in the hand.
     * @return bool True if the hand is a flush, false otherwise.
     */
    private function handFlush($suits): bool {
        return count(array_unique($suits)) == 1;
    }

    /**
     * Checks if the hand is a full house.
     *
     * @param array $values The values of the cards in the hand.
     * @return bool True if the hand is a full house, false otherwise.
     */
    private function handFullHouse($values): bool {
        $counts = array_count_values($values);
        return count($counts) == 2 && in_array(3, $counts);
    }



    /**
     * Checks if the hand is four of a kind.
     *
     * @param array $values The values of the cards in the hand.
     * @return bool True if the hand is four of a kind, false otherwise.
     */
    private function handFourOfAKind($values): bool {
        return count(array_unique($values)) == 2 && max(array_count_values($values)) == 4;
    }


    /**
     * Checks if the hand is a Straight Flush.
     *
     * @param array $values The values of the cards in the hand.
     * @param array $suits The suits of the cards in the hand.
     * @return bool True if the hand is a Straight Flush, false otherwise.
     */
    public function handStraightFlush($values, $suits): bool {
        $flush = $this->handFlush($suits);
        $straight = $this->handStraight($values);

        return $flush && $straight;
    }



    /**
     * Checks if the hand is a Royal Flush.
     *
     * @param array $values The values of the cards in the hand.
     * @param array $suits The suits of the cards in the hand.
     * @return bool True if the hand is a Royal Flush, false otherwise.
     */
    public function handRoyalFlush($values, $suits): bool {
        $straightFlush = $this->handStraightFlush($values, $suits);
        $hasTen = in_array(10, $values);
        $aceHighestCard = max($values) == 14;

        return $straightFlush && $hasTen && $aceHighestCard;
    }
}
