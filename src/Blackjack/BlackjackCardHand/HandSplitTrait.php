<?php

namespace App\Blackjack\BlackjackCardHand;

use App\Deck\DeckOfCards52;
use App\Exception\HandNotSplittableException;

/**
 * HandSplit-Trait, contains all the BlackjackCardHand's
 * split-hand logic.
 *
 */
trait HandSplitTrait
{
    /**
     * Method that checks if the hand consists of two face cards.
     *
     * @return bool True if the hand is splittable, otherwise False.
     */
    public function isSplittable(): bool
    {
        if (count($this->cards) !== 2) {
            return false;
        }

        foreach ($this->cards as $card) {
            if (!$card->isFaceCard()) {
                return false;
            }
        }

        return true;
    }

    /**
     * Method that splits a 2 facecard hand into 2 hands, and then
     * adds supplementary second cards from a given deck to each,
     * and returns the hands in an array.
     *
     * @param DeckOfCards52 $deck The DeckOfCards object for the deck in use.
     *
     * @return BlackjackCardHand[] An array with the two hands.
     */
    public function splitHand($deck): array
    {
        if (!$this->isSplittable()) {
            throw new HandNotSplittableException();
        }

        $firstCard = $this->cards[0];
        $secondCard = $this->cards[1];

        $firstSplittedHand = new BlackjackCardHand([$firstCard]);
        $secondSplittedHand = new BlackjackCardHand([$secondCard]);

        $firstCard = $deck->drawCard();
        $secondCard = $deck->drawCard();

        if ($firstCard && $secondCard) {
            $firstSplittedHand->addCard($firstCard);
            $secondSplittedHand->addCard($secondCard);
        };

        return [$firstSplittedHand, $secondSplittedHand];
    }

}
