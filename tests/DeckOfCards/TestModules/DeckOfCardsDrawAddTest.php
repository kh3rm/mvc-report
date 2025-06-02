<?php

namespace App\Tests\DeckOfCards\TestModules;

use App\Card\Card;
use App\Deck\DeckOfCards;

// use App\Exception\ExcessiveDiceValueException;

/**
 * DrawAddTest cases for the class DeckOfCards.
 */
trait DeckOfCardsDrawAddTest
{
    /**
     * Construct object and verify that the drawCards()-method works properly.
     */
    public function testDrawCards()
    {
        $deck = new DeckOfCards();
        $nrCardsInDeck = count($deck->getCards());

        $drawnCards = $deck->drawCards(3);

        $this->assertEquals($nrCardsInDeck - 3, $deck->getNumberOfCardsLeft());

        $this->assertCount(3, $drawnCards);

        foreach ($drawnCards as $card) {
            $this->assertInstanceOf(Card::class, $card);
        }
    }

    /**
     * Construct object and verify that the drawCard()-method works properly when
     * there are no cards left, and that it returns a null value.
     */
    public function testDrawCardNoCardsLeft()
    {
        $deck = new DeckOfCards();

        $deck->drawCards(54);

        $nrCardsInDeck = count($deck->getCards());

        $nullDrawnCard = $deck->drawCard();

        $this->assertNull($nullDrawnCard);

        $this->assertEquals($nrCardsInDeck, $deck->getNumberOfCardsLeft());

    }


    /**
     * Construct object and verify that the drawCard()-method works properly when
     * there are no cards left, and that it returns a null value.
     */
    public function testDrawCardsNoCardsLeft()
    {
        $deck = new DeckOfCards();

        $deck->drawCards(54);

        $nrCardsInDeck = count($deck->getCards());

        $nullDrawnCards = $deck->drawCards(3);

        $this->assertNull($nullDrawnCards);

        $this->assertEquals($nrCardsInDeck, $deck->getNumberOfCardsLeft());

    }


    /**
     * Construct object and verify that the drawCards()-method works properly when
     * fed an excessive amount (more than the cards in deck), i.e, that it returns null
     * and leaves the deck unchanged.
     *
     */
    public function testDrawCardsExcessiveNr()
    {
        $deck = new DeckOfCards();

        $nullDrawnCards = $deck->drawCards(55);

        $nrCardsInDeck = count($deck->getCards());

        $this->assertNull($nullDrawnCards);

        $this->assertEquals($nrCardsInDeck, 54);

    }

    /**
     * Construct object and verify that the drawCards()-method works properly when
     * fed an negative amount, i.e, that it returns null and leaves the deck unchanged.
     *
     */
    public function testDrawCardsNegativeNr()
    {
        $deck = new DeckOfCards();

        $nullDrawnCards = $deck->drawCards(-1);

        $nrCardsInDeck = count($deck->getCards());

        $this->assertNull($nullDrawnCards);

        $this->assertEquals($nrCardsInDeck, 54);

    }


    /**
     * Construct object and verify that the drawCards()-method works properly when
     * fed a zero, i.e, that it returns null and leaves the deck unchanged.
     *
     */
    public function testDrawCardsZero()
    {
        $deck = new DeckOfCards();

        $nullDrawnCards = $deck->drawCards(0);

        $nrCardsInDeck = count($deck->getCards());

        $this->assertNull($nullDrawnCards);

        $this->assertEquals($nrCardsInDeck, 54);

    }


    /**
     * Construct object and verify that the getdrawnCards()-method works properly.
     *
     */
    public function testGetDrawnCards()
    {
        $deck = new DeckOfCards();

        $drawnCards = $deck->drawCards(5);

        $getDrawnCards = $deck->getDrawnCards();

        $this->assertEquals($drawnCards, $getDrawnCards);

    }



    /**
     * Construct object and verify that the getNumberOfCardsLeft()-method works properly.
     */
    public function testGetNumberOfCardsLeft()
    {
        $deck = new DeckOfCards();
        $nrCardsInDeck = count($deck->getCards());
        $initialCount = $deck->getNumberOfCardsLeft();
        $this->assertEquals($nrCardsInDeck, $initialCount, 54);

    }


    /**
     * Construct object and verify that the addCard()-method is working properly, by
     * adding a single card to the deck.
     */
    public function testAddCardSingle()
    {
        $deck = new DeckOfCards();
        $deck->emptyDeck();
        $card = new Card("5♦", 305, "🃅", "diamond", "red", 5);

        $deck->addCard($card);

        $cardsInDeck = $deck->getCards();
        $this->assertCount(1, $cardsInDeck);
        $this->assertSame($card, $cardsInDeck[0]);
    }


    /**
     * Construct object and verify that the addCard()-method is working properly, by
     * adding multiple (3) cards to the deck.
     */
    public function testAddCardMultiple()
    {
        $deck = new DeckOfCards();
        $deck->emptyDeck();
        $cardOne = new Card("5♦", 305, "🃅", "diamond", "red", 5);
        $cardTwo = new Card("A♠", 114, "🂡", "spade", "black", 14);
        $cardThree = new Card("10♣", 410, "🃚", "club", "black", 10);

        $deck->addCard($cardOne);
        $deck->addCard($cardTwo);
        $deck->addCard($cardThree);


        $cardsInDeck = $deck->getCards();
        $this->assertCount(3, $cardsInDeck);

        $this->assertSame($cardOne, $cardsInDeck[0]);
        $this->assertSame($cardTwo, $cardsInDeck[1]);
        $this->assertSame($cardThree, $cardsInDeck[2]);
    }


    /**
     * Construct object, draw cards, then add some back and verify the correct
     * functionality of the deck in terms of the number of cards left and drawn cards.
     */
    public function testAddCardsAfterDrawing()
    {
        $deck = new DeckOfCards();

        $deck->drawCards(3);
        $this->assertEquals(51, $deck->getNumberOfCardsLeft());

        $cardOne = new Card("5♦", 305, "🃅", "diamond", "red", 5);
        $cardTwo = new Card("A♠", 114, "🂡", "spade", "black", 14);
        $deck->addCard($cardOne);
        $deck->addCard($cardTwo);


        $this->assertEquals(53, $deck->getNumberOfCardsLeft());


        $drawnCards = $deck->getDrawnCards();
        $this->assertCount(3, $drawnCards);
    }

}
