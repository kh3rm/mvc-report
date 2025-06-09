<?php namespace App\PokerPatienceGS;
use App\Exception\IncorrectGridFormatException;

/**
 * Class EvaluateHands
 *
 * This class evaluates poker hands from a 5x5 grid representing a game state.
 */
trait HandEvaluationTrait {


    /**
     * Evaluates all hands and returns their scores.
     *
     * @param array $hands An array of hands to evaluate.
     * @return array An array with the scores of the evaluated hands.
     */
    private function evaluateHands(array $hands): array {
        $results = [];
        foreach ($hands as $hand) {
            $results[] = $this->evaluateHand($hand);
        }
        return $results;
    }

    /**
     * Evaluates a single hand and returns its score.
     *
     * @param array $hand The hand to evaluate.
     * @return int The score of the evaluated hand.
     */
    private function evaluateHand(array $hand): int {
        $values = [];
        $suits = [];
        foreach ($hand as $card) {
            $cardStr = (string) $card;

            if (strlen($cardStr) >= 2) {
                $suit = intval($cardStr[0]);
                $value = intval(substr($cardStr, 1, strlen($cardStr) - 1));

                if ($value >= 2 && $value <= 14) {
                    $values[] = $value;
                    $suits[] = $suit;
                }
            }
        }

        if (count($values) < 5) {
            return 0;
        }

        if ($this->handRoyalFlush($values, $suits)) {
            return 150;
        } elseif ($this->handStraightFlush($values, $suits)) {
            return 75;
        } elseif ($this->handFourOfAKind($values)) {
            return 50;
        } elseif ($this->handFullHouse($values)) {
            return 25;
        } elseif ($this->handFlush($suits)) {
            return 20;
        } elseif ($this->handStraight($values)) {
            return 15;
        } elseif ($this->handThreeOfAKind($values)) {
            return 10;
        } elseif ($this->handTwoPairs($values)) {
            return 5;
        } elseif ($this->handOnePair($values)) {
            return 2;
        }

        return 0;
    }

}
