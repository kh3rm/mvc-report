<?php

namespace App\Tests\BlackjackCardHand\TestModules;

use App\Blackjack\BlackjackCardHand\BlackjackCardHand;
use App\Card\Card;
use App\Exception\InvalidCardException;



/**
 * Test cases for the class BlackjackCardHand.
 */
trait BlackjackCardHandGetAddTest
{
    /**
     * Construct object with arguments and verify that the object has the expected
     * properties, that the getCards()-method is working properly, and that the
     * object's card property only contains instances of Card.
     */
    public function testGetCards()
    {
        $cards = [new Card("8♣", 408, "🃘", "club", "black", 8)];
        $hand = new BlackjackCardHand($cards);
        $this->assertInstanceOf(BlackjackCardHand::class, $hand);

        $cardsInHand = $hand->getCards();
        foreach ($cardsInHand as $card) {
            $this->assertInstanceOf(Card::class, $card);
        }
    }


    /**
     * Construct object and verify that addCard()-method works properly with a valid
     * Card-object supplied.
     */
    public function testaddCard()
    {
        $hand = new BlackjackCardHand();

        $cardsInHand = $hand->getCards();

        $this->assertCount(0,  $cardsInHand);

        $hand->addCard(new Card("8♣", 408, "🃘", "club", "black", 8));

        $cardsInHandTwo = $hand->getCards();

        $this->assertCount(1,  $cardsInHandTwo);
    }


    /**
     * Construct object and verify that addCard()-method works correctly when a
     * non-Card-object value is supplied as an argument.
     */
    public function testaddCardFaultyArgument()
    {
        $hand = new BlackjackCardHand();

        $this->expectException(\TypeError::class);

        $hand->addCard("Faulty argument");


        $this->expectException(\TypeError::class);

        $hand->addCard(123);


        $this->expectException(\TypeError::class);

        $hand->addCard([123, "Faulty argument three"]);

    }




    /**
     * Construct object and verify that addCards()-method works properly with an array of
     * valid Card-objects supplied.
     */
    public function testaddCards()
    {
        $hand = new BlackjackCardHand();

        $cardsInHand = $hand->getCards();

        $this->assertCount(0,  $cardsInHand);

        $cards = [
            new Card("8♣", 408, "🃘", "club", "black", 8),
            new Card("K♥", 213, "🂾", "heart", "red", 13)
        ];

        $hand->addCards($cards);

        $cardsInHandTwo = $hand->getCards();

        $this->assertCount(2,  $cardsInHandTwo);
    }


    /**
     * Construct object and verify that addCards()-method throws a custom
     * InvalidCardException-error when an array containing anything else than
     * Card-objects is supplied as an argument.
     */
    public function testaddCardsFaultyArgument()
    {
        $hand = new BlackjackCardHand();

        $cardsInHand = $hand->getCards();

        $this->assertCount(0,  $cardsInHand);

        $cards = [
            new Card("8♣", 408, "🃘", "club", "black", 8),
            "Faulty argument"
        ];

        $this->expectException(InvalidCardException::class);

        $hand->addCards($cards);
    }




    /**
     * Construct object with two cards, and test that the method currentHandValue() returns the
     * correct value.
     */
    public function testGetCurrentValue()
    {
        $cards = [
            new Card("8♣", 408, "🃘", "club", "black", 8),
            new Card("K♥", 213, "🂾", "heart", "red", 13)
        ];

        $hand = new BlackjackCardHand($cards);

        $expectedHandValue = 18;

        $retrivedHandValue = $hand->currentHandValue();

        $this->assertEquals($expectedHandValue, $retrivedHandValue);
    }



    /**
     * Construct object with two cards, and test that the method currentHandValue() returns the
     * correct value with aces, and that it then changes dynamically according to blackjack-logic
     * when added another card that would leave to being bust, where the default 11 value of an
     * ace instead changes to 1.
     */
    public function testGetCurrentValueWithAce()
    {
        $cards = [
            new Card("A♥", 214, "🂱", "heart", "red", 14),
            new Card("3♠", 103, "🂣", "spade", "black", 3)
        ];

        $hand = new BlackjackCardHand($cards);
        $expectedHandValue = 14;
        $retrivedHandValue = $hand->currentHandValue();

        $this->assertEquals($expectedHandValue, $retrivedHandValue);

        $hand->addCard(new Card("K♥", 213, "🂾", "heart", "red", 13));

        $retrivedHandValueTwo = $hand->currentHandValue();

        $this->assertEquals($expectedHandValue,  $retrivedHandValueTwo);
    }

}