<?php

namespace App\Tests\DeckOfCards\TestModules;

use App\Card\Card;
use App\Deck\DeckOfCards;

// use App\Exception\ExcessiveDiceValueException;

/**
 * Test cases for the class DeckOfCards.
 */
trait DeckOfCardsUnicodeTest
{
    /**
     * Construct object and verify that the getUnicodeOfRoundCards()-method works properly.
     *
     */
    public function testGetUnicodeOfRoundCards()
    {
        $deck = new DeckOfCards();
        $deck->emptyDeck();

        $cardOne = new Card("5♦", 305, "🃌", "diamond", "red", 5);
        $cardTwo = new Card("A♠", 114, "🂡", "spade", "black", 14);
        $cardThree = new Card("10♥", 410, "🂴", "heart", "red", 10);

        $drawnCards = [$cardOne, $cardTwo, $cardThree];

        $deck = new DeckOfCards();
        $deck->emptyDeck();

        $unicodeRepr = $deck->getUnicodeOfRoundCards($drawnCards);


        $expectedUnicodeRepr = "🃌🂡🂴";

        $this->assertEquals($expectedUnicodeRepr, $unicodeRepr);
    }


    /**
     * Construct empty object and verify that the testGetCardsUnicode()-method works
     * correctly, by first adding three cards, and asserting that the string returned
     * from the method matches the expected one.
     */
    public function testGetCardsUnicode()
    {
        $deck = new DeckOfCards();
        $deck->emptyDeck();

        $cardOne = new Card("5♦", 305, "🃅", "diamond", "red", 5);
        $cardTwo = new Card("A♠", 114, "🂡", "spade", "black", 14);
        $cardThree = new Card("10♥", 410, "🂺", "heart", "red", 10);

        $deck->addCard($cardOne);
        $deck->addCard($cardTwo);
        $deck->addCard($cardThree);

        $cardsUnicode = $deck->getCardsUnicode();
        $cards = $deck->getCards();

        $expectedUnicode = "";

        foreach ($cards as $card) {
            $expectedUnicode .= $card->getCardAsUnicode();
        }

        $this->assertEquals($expectedUnicode, $cardsUnicode);
    }




    /**
     * Construct empty object and verify that the testGetCardsDrawnUnicode()-method works
     * correctly, by first adding three cards, drawing them from the deck, and asserting
     * that the string returned from the method matches the expected one.
     */
    public function testGetCardsDrawnUnicode()
    {
        $deck = new DeckOfCards();
        $deck->emptyDeck();

        $cardOne = new Card("5♦", 305, "🃅", "diamond", "red", 5);
        $cardTwo = new Card("A♠", 114, "🂡", "spade", "black", 14);
        $cardThree = new Card("10♥", 410, "🂺", "heart", "red", 10);

        $deck->addCard($cardOne);
        $deck->addCard($cardTwo);
        $deck->addCard($cardThree);

        $deck->drawCards(3);

        $drawnCardsUnicode = $deck->getCardsDrawnUnicode();
        $drawnCards = $deck->getDrawnCards();

        $expectedUnicode = "";

        foreach ($drawnCards as $card) {
            $expectedUnicode .= $card->getCardAsUnicode();
        }

        $this->assertEquals($expectedUnicode, $drawnCardsUnicode);
    }

}
