<?php

namespace App\PokerPatienceGS;

/**
 * Class EvaluateHands
 *
 * This class evaluates poker hands from a 5x5 grid representing a game state.
 */
trait HandScoringTrait
{
    /**
     * Checks if the hand has one pair.
     *
     * @param int[] $values The values of the cards in the hand.
     * @return bool True if the hand contains exactly one pair, false otherwise.
     */
    private function handOnePair($values): bool
    {
        return count(array_unique($values)) == 4;
    }




    /**
     * Checks if the hand has two pairs.
     *
     * @param int[] $cardValues The values of the cards in the hand.
     * @return bool True if the hand contains two pairs, false otherwise.
     */
    private function handTwoPairs($cardValues): bool
    {
        $cardValueCounts = array_count_values($cardValues);

        $nrOfUniqueCardValues = count($cardValueCounts);
        $numberOfPairsFound = count(array_filter($cardValueCounts, fn ($count) => $count === 2));

        return $nrOfUniqueCardValues === 3 && $numberOfPairsFound === 2;
    }

    /**
     * Checks if the hand has three of a kind.
     *
     * @param int[] $values The values of the cards in the hand.
     * @return bool True if the hand contains three of a kind, false otherwise.
     */
    private function handThreeOfAKind($values): bool
    {


        $valueCounts = array_count_values($values);
        return count($valueCounts) == 3 && max($valueCounts) == 3;
    }

    /**
     * Checks if the hand is a straight.
     *
     * @param int[] $values The values of the cards in the hand.
     * @return bool True if the hand is a straight, false otherwise.
     */
    private function handStraight($values): bool
    {
        $uniqueValues = array_unique($values);
        sort($uniqueValues);

        if (count($uniqueValues) < 5) {
            return false;
        }

        if ($uniqueValues[4] - $uniqueValues[0] == 4 && count($uniqueValues) == 5) {
            return true;
        }

        if ($uniqueValues === [2, 3, 4, 5, 14]) {
            return true;
        }

        return false;
    }



    /**
     * Checks if the hand is a flush.
     *
     * @param int[] $suits The suit number of the cards in the hand
     * @return bool True if the hand is a flush, false otherwise.
     */
    private function handFlush($suits): bool
    {
        return count(array_unique($suits)) == 1;
    }

    /**
     * Checks if the hand is a full house.
     *
     * @param int[] $values The values of the cards in the hand.
     * @return bool True if the hand is a full house, false otherwise.
     */
    private function handFullHouse($values): bool
    {
        $counts = array_count_values($values);
        return count($counts) == 2 && in_array(3, $counts);
    }



    /**
     * Checks if the hand is four of a kind.
     *
     * @param int[] $values The values of the cards in the hand.
     * @return bool True if the hand is four of a kind, false otherwise.
     */
    private function handFourOfAKind($values): bool
    {

        $valueCounts = array_count_values($values);


        return count($valueCounts) == 2 && max($valueCounts) == 4;
    }







    /**
     * Checks if the hand is a Straight Flush.
     *
     * @param int[] $values The values of the cards in the hand
     * @param int[] $suits The suit number of the cards in the hand
     * @return bool True if the hand is a Straight Flush, false otherwise.
     */
    public function handStraightFlush($values, $suits): bool
    {

        $flush = $this->handFlush($suits);
        $straight = $this->handStraight($values);

        return $flush && $straight;
    }


    /**
     * Checks if the hand is a Royal Flush.
     *
     * @param int[] $values The values of the cards in the hand
     * @param int[] $suits The suit number of the cards in the hand
     * @return bool True if the hand is a Royal Flush, false otherwise.
     */
    public function handRoyalFlush(array $values, array $suits): bool
    {
        assert(!empty($values), 'Expected values array to not be empty');

        $straightFlush = $this->handStraightFlush($values, $suits);
        $hasTen = in_array(10, $values);
        $aceHighestCard = max($values) == 14;

        return $straightFlush && $hasTen && $aceHighestCard;
    }



}
