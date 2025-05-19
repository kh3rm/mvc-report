<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

use App\Card\Card;

// use App\Exception\ExcessiveDiceValueException;

/**
 * Test cases for the class DeckOfCards.
 */
class DeckOfCardsTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateDeckOfCards()
    {
        $deck = new DeckOfCards();
        $this->assertInstanceOf("\App\Card\DeckOfCards", $deck);
        $this->assertNotEmpty($deck);
    }

    /**
     * Construct object and verify that the object's retrieved cards only containes
     * instances of Card, also confirming that the getCards() is functioning properly.
     *
     */
    public function testCreateDeckOfCardsComplete()
    {
        $deck = new DeckOfCards();
        $this->assertInstanceOf("\App\Card\DeckOfCards", $deck);
        $cardsInDeck = $deck->getCards();
        $this->assertContainsOnlyInstancesOf(Card::class, $cardsInDeck);
        $this->assertCount(54, $cardsInDeck);
    }


    /**
     * Construct an empty deck (by feeding the constructor a false boolean) and verify
     * that the object's retrieved cards is empty.
     *
     */
    public function testCreateDeckOfCardsEmpty()
    {
        $deck = new DeckOfCards(false);
        $this->assertInstanceOf("\App\Card\DeckOfCards", $deck);
        $cardsInDeck = $deck->getCards();
        $this->assertCount(0, $cardsInDeck);
    }


    /**
     * Construct object and verify that the object's retrieved cards contains
     * 54 cards, 13+13+13+13(+2), 13 of each suit (+jokers).
     *
     */
    public function testCardsSuitCount()
    {
        $deck = new DeckOfCards();
        $this->assertInstanceOf("\App\Card\DeckOfCards", $deck);
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
     * Construct object and verify that the object's retrieved cards contains
     * 54 cards, 13 ranks each appearing 4 times (excluding the jokers).
     */
    public function testCardsRank()
    {
        $deck = new DeckOfCards();
        $this->assertInstanceOf("\App\Card\DeckOfCards", $deck);
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
        $deck = new DeckOfCards(false);
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
        $deck = new DeckOfCards(false);
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
     * Construct object and verify that the sortDeck()-method is working properly, by
     * adding 10 randomized example cards to an empty deck, using the sort method,
     * and ascertaining that the cards are now sorted in the expected order.
     */
    public function testSortDeck()
    {
        $deck = new DeckOfCards(false);

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
        $deck = new DeckOfCards(false);

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
        $deck = new DeckOfCards(false);

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



    /**
     * Construct object and verify that the getUnicodeOfRoundCards()-method works properly.
     *
     */
    public function testGetUnicodeOfRoundCards()
    {
        $deck = new DeckOfCards();

        $cardOne = new Card("5♦", 305, "🃌", "diamond", "red", 5);
        $cardTwo = new Card("A♠", 114, "🂡", "spade", "black", 14);
        $cardThree = new Card("10♥", 410, "🂴", "heart", "red", 10);

        $drawnCards = [$cardOne, $cardTwo, $cardThree];

        $deck = new DeckOfCards();

        $unicodeRepresentation = $deck->getUnicodeOfRoundCards($drawnCards);


        $expectedUnicodeRepresentation = "🃌🂡🂴";

        $this->assertEquals($expectedUnicodeRepresentation, $unicodeRepresentation);
    }


    /**
     * Construct empty object and verify that the testGetCardsUnicode()-method works
     * correctly, by first adding three cards, and asserting that the string returned
     * from the method matches the expected one.
     */
    public function testGetCardsUnicode()
    {
        $deck = new DeckOfCards(false);
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
        $deck = new DeckOfCards(false);
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




/* $this->expectException(ExcessiveDiceValueException::class); */