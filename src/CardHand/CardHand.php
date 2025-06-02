<?php

namespace App\CardHand;

use App\Card\Card;
use App\Exception\InvalidCardException;

/**
 * CardHand-class, representing a hand containing instances of Card.
 */
class CardHand
{
    /**
     * An array that holds the Card-objects currently in hand.
     *
     * @var Card[]  $cards  An array of Card instances.
     */
    protected array $cards = [];

    /**
     * An array that holds Card-objects previously discarded.
     *
     * @var Card[]  $cardsDiscarded  An array of Card instances.
     */
    protected array $cardsDiscarded = [];


    /**
     * Constructor that uses the addCards()-method to populate the CardHand
     * with the instanses of Card supplied in the $cardsDealt-parameter.
     *
     *  @param Card[] $cardsDealt  An array of Card instances.
     */
    public function __construct(array $cardsDealt = [])
    {
        $this->addCards($cardsDealt);
    }

    /**
     * Method that populates(or adds to) the CardHand with instances of Card supplied
     * in the $addedCards-parameter.
     *
     *  @param Card[] $addedCards  An array of Card instances.
     */
    public function addCards(array $addedCards): void
    {
        foreach ($addedCards as $card) {
            if (!$card instanceof Card) {
                throw new InvalidCardException();
            }
            $this->cards[] = $card;
        }
    }


    /**
     * Method that adds to the $card-array attribute the instance of Card supplied.
     *
     *  @param Card $card An instance of Card.
     */
    public function addCard(Card $card): void
    {
        $this->cards[] = $card;
    }


    /**
     * Method that returns the $cards-array of all Cards in hand.
     *
     *  @return Card[] An array of Card instances.
     */
    public function getCards(): array
    {
        return $this->cards;
    }


    /**
     * Method that returns the $cardsDiscarded-array of all
     * discarded Cards from the hand.
     *
     *  @return Card[] An array of Card instances.
     */
    public function getCardsDiscarded(): array
    {
        return $this->cardsDiscarded;
    }

    /**
     * Method that returns all the cards in hand as a string,
     * separated by a comma.
     *
     *  @return string A string of all the cards in hand.
     */
    public function getCardsAsString(): string
    {
        return implode(", ", array_map(fn ($card) => $card->getAsString(), $this->cards));
    }


    /**
     * Method that returns all the discarded cards from the
     * hand as a string, separated by a comma.
     *
     *  @return string A string of all the discarded cards.
     */
    public function getDiscardedCardsAsString(): string
    {
        return implode(", ", array_map(fn ($card) => $card->getAsString(), $this->cardsDiscarded));
    }

    /**
     * Method that returns all the cards in hand in their Unicode representation.
     *
     *  @return string A string of all the cards in hand in Unicode-format.
     */
    public function getCardsAsUnicode(): string
    {
        return implode("", array_map(fn ($card) => $card->getCardAsUnicode(), $this->cards));
    }

    /**
     * Method that returns all the discarded cards in hand in their Unicode
     * representation.
     *
     *  @return string A string of all the discarded cards from the hand in Unicode-format.
     */
    public function getDiscardedCardsAsUnicode(): string
    {
        return implode("", array_map(fn ($card) => $card->getCardAsUnicode(), $this->cardsDiscarded));
    }

}
