<?php

namespace App\Blackjack\BlackjackCardHand;

use App\Card\Card;
use App\Deck\DeckOfCards52;
use App\Exception\InvalidCardException;

/**
 * BlackjackCardHand-class, representing a Blackjack-hand containing instances of Card.
 */
class BlackjackCardHand
{
    use ActiveHandHandlingTrait;
    use HandEvaluationTrait;
    use HandSplitTrait;

    /**
     * An array that holds the Card-objects currently in hand.
     *
     * @var Card[]  $cards  An array of Card instances.
     */
    protected array $cards = [];


    /**
     * A boolean that indicates if the hand is active.
     *
     * @var bool $handActive Set to true at instantiation, and can be changed with the setter.
     */
    protected bool $handActive;


    /**
     * Constructor that uses the addCards()-method to populate the CardHand
     * with the instanses of Card supplied in the $cardsDealt-parameter.
     *
     *  @param Card[] $cardsDealt  An array of Card instances.
     */
    public function __construct(array $cardsDealt = [])
    {
        $this->addCards($cardsDealt);
        $this->handActive = true;
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
     * Method that adds to the $card-array attribute the instance of Card supplied.
     *
     *  @param Card $card An instance of Card.
     */
    public function addCard(Card $card): void
    {
        $this->cards[] = $card;
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
     *  @param DeckOfCards52 $deck An instance of DeckOfCards52.
     */
    public function drawCardFromDeck(DeckOfCards52 $deck): void
    {
        $card = $deck->drawCard();

        if ($card !== null) {
            $this->cards[] = $card;
        }
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
}
