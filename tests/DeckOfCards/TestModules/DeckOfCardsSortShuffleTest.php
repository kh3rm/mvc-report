<?php

namespace App\Tests\DeckOfCards\TestModules;

use App\Card\Card;
use App\Deck\DeckOfCards;

// use App\Exception\ExcessiveDiceValueException;

/**
 * Test cases for the class DeckOfCards.
 */
trait DeckOfCardsSortShuffleTest
{

    /**
     * Construct object and verify that the sortDeck()-method is working properly, by
     * adding 10 randomized example cards to an empty deck, using the sort method,
     * and ascertaining that the cards are now sorted in the expected order.
     */
    public function testSortDeck()
    {
        $deck = new DeckOfCards();
        $deck->emptyDeck();

        $deck->addCard(new Card("5♦", 305, "🃅", "diamond", "red", 5));
        $deck->addCard(new Card("8♣", 408, "🃘", "club", "black", 8));
        $deck->addCard(new Card("A♥", 214, "🂱", "heart", "red", 14));
        $deck->addCard(new Card("3♠", 103, "🂣", "spade", "black", 3));
        $deck->addCard(new Card("K♥", 213, "🂾", "heart", "red", 13));
        $deck->addCard(new Card("7♦", 307, "🃇", "diamond", "red", 7));
        $deck->addCard(new Card("6♠", 106, "🂦", "spade", "black", 6));
        $deck->addCard(new Card("9♠", 109, "🂩", "spade", "black", 9));
        $deck->addCard(new Card("10♣", 410, "🃚", "club", "black", 10));
        $deck->addCard(new Card("4♥", 204, "🂴", "heart", "red", 4));


        $nrCardsInDeck = count($deck->getCards());


        $this->assertEquals($nrCardsInDeck, 10);


        $deck->sortDeck();


        $expectedOrder = [
             "3♠", "6♠", "9♠", "4♥", "K♥", "A♥", "5♦",  "7♦", "8♣",  "10♣"
        ];

        $actualOrder = array_map(function($card) {
            return $card->getAsString();
        }, $deck->getCards());

        $this->assertEquals($expectedOrder, $actualOrder);
    }




    /**
     * Construct object and verify that the sortDeckFirstByRankThenBySuit()-method
     * is working properly, by adding 10 randomized example cards to an empty deck,
     * using the alternative sort method, and ascertaining that the cards are now sorted
     * in the expected order.
     */
    public function testSortDeckFirstByRankThenBySuit()
    {
        $deck = new DeckOfCards();
        $deck->emptyDeck();

        $deck->addCard(new Card("5♣", 405, "🃕", "club", "black", 5));
        $deck->addCard(new Card("A♠", 114, "🂡", "spade", "black", 14));
        $deck->addCard(new Card("3♥", 203, "🂳", "heart", "red", 3));
        $deck->addCard(new Card("2♠", 102, "🂢", "spade", "black", 2));
        $deck->addCard(new Card("4♦", 304, "🃄", "diamond", "red", 4));
        $deck->addCard(new Card("A♥", 214, "🂱", "heart", "red", 14));
        $deck->addCard(new Card("A♦", 314, "🃁", "diamond", "red", 14));
        $deck->addCard(new Card("3♣", 403, "🃓", "club", "black", 3));
        $deck->addCard(new Card("2♣", 402, "🃒", "club", "black", 2));
        $deck->addCard(new Card("5♦", 305, "🃅", "diamond", "red", 5));


        $nrCardsInDeck = count($deck->getCards());
        $this->assertEquals($nrCardsInDeck, 10);


        $deck->sortDeckFirstByRankThenBySuit();


        $expectedOrder = [
            "2♠", "2♣", "3♥", "3♣", "4♦", "5♦", "5♣", "A♠", "A♥", "A♦"
        ];

        $actualOrder = array_map(function($card) {
            return $card->getAsString();
        }, $deck->getCards());

        $this->assertEquals($expectedOrder, $actualOrder);
    }


    public function testShuffleDeck()
    {
        $deck = new DeckOfCards();
        $deck->emptyDeck();

        $deck->addCard(new Card("5♦", 305, "🃅", "diamond", "red", 5));
        $deck->addCard(new Card("8♣", 408, "🃘", "club", "black", 8));
        $deck->addCard(new Card("A♥", 214, "🂱", "heart", "red", 14));
        $deck->addCard(new Card("3♠", 103, "🂣", "spade", "black", 3));
        $deck->addCard(new Card("K♥", 213, "🂾", "heart", "red", 13));


        $originalOrder = array_map(function($card) {
            return $card->getAsString();
        }, $deck->getCards());

        $shuffledOrder = $originalOrder;
        $shuffleAttempts = 50;
        $shuffledSuccessfully = false;

        for ($i = 0; $i < $shuffleAttempts; $i++) {
            $deck->shuffleDeckOfCards();


            $shuffledOrder = array_map(function($card) {
                return $card->getAsString();
            }, $deck->getCards());

            if ($originalOrder !== $shuffledOrder) {
                $shuffledSuccessfully = true;
                break;
            }
        }

        $this->assertTrue($shuffledSuccessfully);

        sort($originalOrder);
        sort($shuffledOrder);

        $this->assertEquals($originalOrder, $shuffledOrder);
    }
}
