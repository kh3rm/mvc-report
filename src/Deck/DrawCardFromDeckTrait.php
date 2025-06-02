<?php

namespace App\Deck;

use App\Card\Card;

/**
 * DrawCardDeckTrait that handles the sorting- and shuffling-functionality
 * of a deck.
 */
trait DrawCardFromDeckTrait
{
    /**
     * Method that draws a random card from the deck, and returns it. If there are no cards
     * left in the deck, it returns null.
     */
    public function drawCard(): ?Card
    {
        if (empty($this->cards)) {
            return null;
        }

        $drawIndex = array_rand($this->cards);
        $drawnCard = $this->cards[$drawIndex];

        $this->drawnCards[] = $drawnCard;

        unset($this->cards[$drawIndex]);

        $this->cards = array_values($this->cards);

        return $drawnCard;
    }


    /**
     * Method that draws/deals and returns {$number} of cards at random from $cards (and also
     * moves those cards over to $drawnCards), using drawCard().
     *
     *  @return Card[] An array of the drawn Card-objects.
     */
    public function drawCards(int $number): ?array
    {
        if ($number < 1) {
            return null;
        }

        if (count($this->cards) < $number) {
            return null;
        }

        $drawnCards = [];

        for ($i = 0; $i < $number; $i++) {
            $drawnCard = $this->drawCard();
            if ($drawnCard !== null) {
                $drawnCards[] = $drawnCard;
            }
        }

        return count($drawnCards) > 0 ? $drawnCards : null;
    }
}
