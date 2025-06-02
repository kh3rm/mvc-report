<?php

namespace App\Deck;

/**
 * DeckOfCards52-Class, extends DeckOfCards, representing a classical deck of 52 regular cards,
 * without jokers.
 */
class DeckOfCards52 extends DeckOfCards
{
    /**
     * Constructor.
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->removeJokers();
    }

    /**
     * removeJokers-method, used to remove the jokers with the help of getCardAsInt(),
     * to constitue a playable 52-card deck.
     *
     */
    private function removeJokers(): void
    {
        $this->cards = array_filter($this->cards, function ($card) {
            return $card->getCardAsInt() !== 0;
        });

        $this->cards = array_values($this->cards);
    }
}
