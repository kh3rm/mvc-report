<?php

namespace App\Card;

use App\Card\Card;
use App\Exception\InvalidCardException;
use App\Exception\HandNotSplittableException;

class BlackjackCardHand
{
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
     * Returns the active status of the hand.
     *
     * @return bool
     */
    public function isHandActive(): bool
    {
        return $this->handActive;
    }


    /**
     * Returns the inactive status of the hand.
     *
     * @return bool
     */
    public function isHandInactive(): bool
    {
        return !$this->handActive;
    }






    /**
     * Sets the handActive-attribute to false.
     *
     */
    public function setHandInactive(): void
    {
        $this->handActive = false;
    }



    /**
     * Checks the status of the hand and updates it if necessary.
     * Sets the hand to inactive if the current hand value exceeds 20.
     */
    public function updateHandStatus(): void
    {
        if ($this->currentHandValue() > 20) {
            $this->setHandInactive();
        }
    }



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



    /**
     * Method that calculates the current value of the blackjack hand, according to blackjack-specific
     * logic.
     *
     * @return int The total value of the cards in hand.
     */
    public function currentHandValue(): int
    {
        $totalValue = 0;
        $aceCount = 0;

        foreach ($this->cards as $card) {
            $rank = $card->getRank();

            if ($rank == 11 || $rank == 12 || $rank == 13) {
                $totalValue += 10;
            }

            if ($rank === 14) {
                $totalValue += 11;
                $aceCount++;
            }

            if ($rank < 11) {
                $totalValue += $rank;
            }
        }

        while ($totalValue > 21 && $aceCount > 0) {
            $totalValue -= 10;
            $aceCount--;
        }

        return $totalValue;
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
     * Method that returns the $cards-array of all Cards in hand.
     *
     *  @return Card[] An array of Card instances.
     */
    public function getCards(): array
    {
        return $this->cards;
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
