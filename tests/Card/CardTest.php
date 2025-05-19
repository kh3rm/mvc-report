<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

use App\Card\Card;

/**
 * Test cases for the class Card.
 */
class CardTest extends TestCase
{
    /**
     * Tests that creating a Card without any arguments throws the expected ArgumentCountError.
     */
    public function testCreateCardNoArguments()
    {
        $this->expectException(\ArgumentCountError::class);
        $card = new Card();
    }

    /**
     * Tests that creating a Card with non-type-matching arguments throws the expected TypeError.
     */
    public function testCreateCardInvalidArguments()
    {
        $this->expectException(\TypeError::class);
        $card = new Card(1, "faulty", "arguments", 99,
         "supplied", "typerror");
    }

    /**
     * Tests that creating a Card with too few arguments throws the expected TypeError.
     */
    public function testCreateCardInsufficientArguments()
    {
        $this->expectException(\TypeError::class);
        $card = new Card("none", 99);
    }

    /**
     * Tests that creating a Card with valid coherent arguments works.
     */
    public function testCreateCardWithValidArguments()
    {
        $card = new Card("5♣", 405, "🃕", "club", "black", 5);
        $this->assertInstanceOf(Card::class, $card);
        $this->assertNotEmpty($card);

    }

    /**
     * Ascertains that the getValue()-method is working properly, and returning expected
     * result.
     */
    public function testGetValue()
    {
        $card = new Card("5♣", 405, "🃕", "club", "black", 5);

        $cardCValue = '5♣';

        $retrievedCardCValue = $card->getValue();

        $this->assertEquals($cardCValue, $retrievedCardCValue);

    }

    /**
     * Ascertains that the getRank()-method is working properly, and returning expected
     * result.
     */
    public function testGetRank()
    {
        $card = new Card("5♣", 405, "🃕", "club", "black", 5);

        $cardRank = 5;

        $retrievedCardRank = $card->getRank();

        $this->assertEquals($cardRank, $retrievedCardRank);

    }

    /**
     * Ascertains that the getSuit()-method is working properly, and returning expected
     * result.
     */
    public function testGetSuit()
    {
        $card = new Card("5♣", 405, "🃕", "club", "black", 5);

        $cardSuit = 'club';

        $retrievedCardSuit = $card->getSuit();

        $this->assertEquals($cardSuit, $retrievedCardSuit);

    }

    /**
     * Ascertains that the getSuit()-method is working properly, and returning expected
     * result.
     */
    public function testGetColor()
    {
        $card = new Card("5♣", 405, "🃕", "club", "black", 5);

        $cardColor = 'black';

        $retrievedCardColor = $card->getColor();

        $this->assertEquals($cardColor, $retrievedCardColor);

    }

    /**
     * Ascertains that the testGetCardAsInt()-method is working properly, and returning expected
     * result.
     */
    public function testGetCardAsInt()
    {
        $card = new Card("5♣", 405, "🃕", "club", "black", 5);

        $cardInt = 405;

        $retrievedCardInt = $card->getCardAsInt();

        $this->assertEquals($cardInt, $retrievedCardInt);

    }


    /**
     * Ascertains that the testGetCardAsInt()-method is working properly, and returning expected
     * result.
     */
    public function testGetBackOfCard()
    {
        $card = new Card("5♣", 405, "🃕", "club", "black", 5);

        $backOfCard = '🂠';

        $retrievedbackOfCard = $card->getBackOfCard();

        $this->assertEquals($backOfCard, $retrievedbackOfCard);

    }

    /**
     * Ascertains that the isFaceCard()-method is working properly, and returning expected
     * result.
     */
    public function testIsFaceCard()
    {
        $cardOne = new Card("5♣", 405, "🃕", "club", "black", 5);
        $cardTwo = new Card("J♠", 111, '🂫', "spade", "black", 11);
        $cardThree = new Card("Q♠", 112, '🂭', "spade", "black", 12);
        $cardFour =  new Card("K♥", 213, "🂾", "heart", "red", 13);
        $cardFive = new Card("A♠", 114, '🂡', "spade", "black", 14);


        $cardOneIFC = false;
        $cardOneIsFaceCard = $cardOne->isFaceCard();
        $this->assertEquals($cardOneIFC, $cardOneIsFaceCard);

        $cardTwoIFC = true;
        $cardTwoIsFaceCard = $cardTwo->isFaceCard();
        $this->assertEquals($cardTwoIFC, $cardTwoIsFaceCard);

        $cardThreeIFC = true;
        $cardThreeIsFaceCard = $cardThree->isFaceCard();
        $this->assertEquals($cardThreeIFC, $cardThreeIsFaceCard);


        $cardFourIFC = true;
        $cardFourIsFaceCard = $cardFour->isFaceCard();
        $this->assertEquals($cardFourIFC, $cardFourIsFaceCard);

        $cardFiveIFC = false;
        $cardFiveIsFaceCard = $cardFive->isFaceCard();
        $this->assertEquals($cardFiveIFC, $cardFiveIsFaceCard);
    }


    /**
     * Ascertains that the testGetCardAsInt()-method is working properly, and returning expected
     * result.
     */
    public function testGetAsString()
    {
        $card = new Card("5♣", 405, "🃕", "club", "black", 5);

        $cardStringValue = '5♣';

        $retrievedCSV = $card->getAsString();

        $this->assertEquals($cardStringValue, $cardStringValue);

    }





}