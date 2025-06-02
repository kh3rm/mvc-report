<?php

namespace App\Deck;

use App\Card\Card;

/**
 * GetCardFromDeckTrait that handles the getting getters of cards
 * fro the deck.
 */
trait GetCardFromDeckTrait
{
    /**
     * Method that returns the $cards-array of all the Card-instances in $cards.
     *
     *  @return Card[] An array of Card instances.
     */
    public function getCards(): array
    {
        return $this->cards;
    }


    /**
     * Method that returns the $drawnCards-array of all the Card-instances
     * in $drawnCards.
     *
     *  @return Card[] An array of Card instances.
     */
    public function getDrawnCards(): ?array
    {
        return $this->drawnCards;
    }
}
