<?php

namespace App\Tests\DeckOfCards\TestModules;

use App\Card\Card;
use App\Deck\DeckOfCards;


/**
 * Test cases for the class DeckOfCards.
 */
trait DeckOfCardsCreateTest
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateDeckOfCards()
    {
        $deck = new DeckOfCards();
        $this->assertInstanceOf(DeckOfCards::class, $deck);
        $this->assertNotEmpty($deck);
    }

    /**
     * Construct object and verify that the object's retrieved cards only contains
     * instances of Card, also confirming that the getCards() is functioning properly.
     *
     */
    public function testCreateDeckOfCardsComplete()
    {
        $deck = new DeckOfCards();
        $this->assertInstanceOf(DeckOfCards::class, $deck);
        $cardsInDeck = $deck->getCards();
        $this->assertContainsOnlyInstancesOf(Card::class, $cardsInDeck);
        $this->assertCount(54, $cardsInDeck);
    }


    /**
     * Construct object and verify that the object's retrieved cards contains
     * 54 cards, 13+13+13+13(+2), 13 of each suit (+jokers).
     *
     */
    public function testCardsSuitCount()
    {
        $deck = new DeckOfCards();
        $this->assertInstanceOf(DeckOfCards::class, $deck);
        $cardsInDeck = $deck->getCards();

        $this->assertCount(54, $cardsInDeck);

        $suitCounts = [
            'spade' => 0,
            'heart' => 0,
            'diamond' => 0,
            'club' => 0,
            'joker' => 0
        ];

        foreach ($cardsInDeck as $card) {
            $suit = $card->getSuit();
            if (isset($suitCounts[$suit])) {
                $suitCounts[$suit]++;
            }
        }

        $this->assertEquals(13, $suitCounts['spade']);
        $this->assertEquals(13, $suitCounts['heart']);
        $this->assertEquals(13, $suitCounts['diamond']);
        $this->assertEquals(13, $suitCounts['club']);
        $this->assertEquals(2, $suitCounts['joker']);
    }


    /**
     * Construct object and verify that the deck's cards are emptied
     * with the help of the method emptyDeck()-method.
     *
     */
    public function testEmptyDeck()
    {
        $deck = new DeckOfCards();

        $cardsInDeck = $deck->getCards();
        $this->assertCount(54, $cardsInDeck);

        $deck->emptyDeck();
        $cardsInDeck = $deck->getCards();
        $this->assertCount(0, $cardsInDeck);
    }



    /**
     * Construct object and verify that the object's retrieved cards contains
     * 54 cards, 13 ranks each appearing 4 times (excluding the jokers).
     */
    public function testCardsRank()
    {
        $deck = new DeckOfCards();
        $this->assertInstanceOf(DeckOfCards::class, $deck);
        $cardsInDeck = $deck->getCards();

        $this->assertCount(54, $cardsInDeck);

        $rankCounts = [
            '2' => 0,
            '3' => 0,
            '4' => 0,
            '5' => 0,
            '6' => 0,
            '7' => 0,
            '8' => 0,
            '9' => 0,
            '10' => 0,
            '11' => 0,
            '12' => 0,
            '13' => 0,
            '14' => 0
        ];


        foreach ($cardsInDeck as $card) {
            $rank = $card->getRank();
            if (isset($rankCounts[$rank])) {
                $rankCounts[$rank]++;
            }
        }

        foreach ($rankCounts as $rank => $count) {
            $this->assertEquals(4, $count);
        }
    }

}
