<?php

namespace App\Deck;

use App\Card\Card;

/**
 * UnicodeRepresentationTrait - handles the Unicode representation of a deck.
 */
trait UnicodeRepresentationTrait
{
    /**
     * Method that returns all the cards in the $cards as a string,
     * in Unicode representation.
     *
     *  @return string A string of all the cards in the deck in Unicode format.
     */
    public function getCardsUnicode(): string
    {
        return implode('', array_map(fn ($card) => $card->getCardAsUnicode(), $this->cards));
    }

    /**
     * Method that returns all the drawn cards as a string,
     * in Unicode representation.
     *
     * @return string A string of all the drawn/dealt cards in the deck in Unicode format.
     */
    public function getCardsDrawnUnicode(): string
    {
        return implode('', array_map(fn ($card) => $card->getCardAsUnicode(), $this->drawnCards));
    }


    /**
     * Method that takes a drawn-card-this-round-array with Card instances and returns
     * a string of its Unicode representation.
     *
     *  @param Card[] $drawnCards  An array of Card instances.
     *  @return string A string of all the drawn/dealt cards in the deck in Unicode format.
     */
    public function getUnicodeOfRoundCards(array $drawnCards): string
    {
        return implode("", array_map(function ($card) {
            return $card->getCardAsUnicode();
        }, $drawnCards));
    }
}
