<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

use App\Card\Card;

// use App\Exception\ExcessiveDiceValueException;

/**
 * Test cases for the class BlackjackCardHand.
 */
class BlackjackCardHandTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateBlackjackCardHand()
    {
        $hand = new BlackjackCardHand();
        $this->assertInstanceOf("\App\Card\BlackjackCardHand", $hand);
    }



    /**
     * Construct object with arguments and verify that the object has the expected
     * properties, and that the BlackjackCardHand contains only instances of Card.
     */
    public function testCreateWithArguments()
    {
        $cards = [new Card("8♣", 408, "🃘", "club", "black", 8)];
        $hand = new BlackjackCardHand($cards);
        $this->assertInstanceOf("\App\Card\BlackjackCardHand", $hand);

    }


    /**
     * Construct object with arguments and verify that the object has the expected
     * properties, that the getCards()-method is working properly, and that the
     * object's card property only contains instances of Card.
     */
    public function testGetCards()
    {
        $cards = [new Card("8♣", 408, "🃘", "club", "black", 8)];
        $hand = new BlackjackCardHand($cards);
        $this->assertInstanceOf("\App\Card\BlackjackCardHand", $hand);

        $cardsInHand = $hand->getCards();
        foreach ($cardsInHand as $card) {
            $this->assertInstanceOf(Card::class, $card);
        }
    }




    /**
     * Construct object and verify that the hand is activated at creation,
     * with the help of the method isHandActive().
     */
    public function testIsHandActive()
    {
        $hand = new BlackjackCardHand();
        $this->assertTrue($hand->isHandActive());
    }

    /**
     * Construct object and verify that the hand is activated (not inactivated) at creation,
     * with the help of the method isHandInactive().
     */
    public function testIsHandNotActive()
    {
        $hand = new BlackjackCardHand();
        $this->assertFalse($hand->isHandInactive());
    }


    /**
     * Construct object and verify that the hand is activated at creation,
     * with the help of the method isHandActive(), and that it is properly
     * inactivated with the help of the method setHandInactive().
     */
    public function testSetHandInactive()
    {
        $hand = new BlackjackCardHand();
        $this->assertTrue($hand->isHandActive());
        $hand->setHandInactive();
        $this->assertTrue($hand->isHandInactive());
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

        $this->expectException(\App\Exception\InvalidCardException::class);

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


    /**
     * Construct a hand with two facecards, and test that the method isSplittable() returns true.
     */
    public function testIsSplittable()
    {
        $cards = [
            new Card("K♥", 213, "🂾", "heart", "red", 13),
            new Card("Q♥", 212, "🂽", "heart", "red", 12)
        ];

        $hand = new BlackjackCardHand($cards);

        $isSplittable = $hand->isSplittable();

        $this->assertTrue($isSplittable);
    }

    /**
     * Construct a hand that does not contain two facecards, and test that the method isSplittable()
     * returns false.
     */
    public function testIsSplittableFalse()
    {
        $cards = [
            new Card("A♥", 214, "🂱", "heart", "red", 14),
            new Card("3♠", 103, "🂣", "spade", "black", 3)
        ];

        $hand = new BlackjackCardHand($cards);

        $isSplittable = $hand->isSplittable();

        $this->assertFalse($isSplittable);
    }



    /**
     * Construct an empty hand that does not contain two facecards, and test that the method isSplittable()
     * returns false.
     */
    public function testIsSplittableEmpty()
    {

        $hand = new BlackjackCardHand();

        $isSplittable = $hand->isSplittable();

        $this->assertFalse($isSplittable);
    }




    /**
     * Construct a hand that contain two facecards, and test that the method splitHand()
     * splits the previous one two-card hand into two two-card hands (in an array), where each
     * of the facecards of the previous hand makes up the foundation of the new hand, and is
     * supplemented with an additional card each from a given deck.
     *
     */
    public function testSplitHand()
    {
        $cards = [
            new Card("K♥", 213, "🂾", "heart", "red", 13),
            new Card("Q♥", 212, "🂽", "heart", "red", 12)
        ];

        $hand = new BlackjackCardHand($cards);

        $deck = new DeckOfCards52;

        $splittedHand = $hand->splitHand($deck);


        $this->assertIsArray($splittedHand);
        $this->assertCount(2, $splittedHand);


        foreach ($splittedHand as $newHand) {
            $this->assertInstanceOf(BlackjackCardHand::class, $newHand);
        }

        $firstCard = $cards[0];
        $secondCard = $cards[1];

        $this->assertContains($firstCard, $splittedHand[0]->getCards());
        $this->assertContains($secondCard, $splittedHand[1]->getCards());

        $this->assertCount(2, $splittedHand[0]->getCards());
        $this->assertCount(2, $splittedHand[1]->getCards());
    }



    /**
     * Test that the method splitHand() on a non-splittable 2 card hand, and ascertain that
     * a HandNotSplittableException is thrown.
     *
     */
    public function testSplitHandInvalid2()
    {
        $cards = [
            new Card("K♥", 213, "🂾", "heart", "red", 13),
            new Card("A♥", 214, "🂱", "heart", "red", 14)
        ];

        $hand = new BlackjackCardHand($cards);

        $deck = new DeckOfCards52;

        $this->expectException(\App\Exception\HandNotSplittableException::class);

        $hand->splitHand($deck);

    }







    /**
     * Construct empty BlackjackCardHand and DeckOfCards52, add a card to the deck,
     * and test that the method drawCardFromDeck() correctly draws that card from the
     * supplied deck.
     */
    public function testDrawCardFromDeck()
    {
        $card =new Card("A♥", 214, "🂱", "heart", "red", 14);

        $deckOfCards52 = new DeckOfCards52();

        $deckOfCards52->emptyDeck();

        $deckOfCards52->addCard($card);

        $this->assertCount(1, $deckOfCards52->getCards());

        $hand = new BlackjackCardHand();



        $this->assertCount(0, $hand->getCards());

        $hand->drawCardFromDeck($deckOfCards52);

        $this->assertCount(1, $hand->getCards());
    }


    /**
     * Construct a hand with the value 21 (blackjack), and ascertain that the
     * updateHandStatus()-method works properly, i.e, updates the hand active
     * value to false.
     */
    public function testUpdateHandStatus21()
    {
        $cards = [
            new Card("K♥", 213, "🂾", "heart", "red", 13),
            new Card("A♥", 214, "🂱", "heart", "red", 14)
        ];

        $hand = new BlackjackCardHand($cards);

        $handActiveStatus = $hand->isHandActive();

        $this->assertTrue($handActiveStatus);

        $hand->updateHandStatus();

        $newHandActiveStatus = $hand->isHandActive();

        $this->assertFalse($newHandActiveStatus);

    }

    /**
     * Construct a hand with a value under 21 , and ascertain that the
     * updateHandStatus()-method works properly, i.e, that the hand status is
     * active also after update.
     */
    public function testUpdateHandStatusSub21()
    {
        $cards = [
            new Card("K♥", 213, "🂾", "heart", "red", 13),
            new Card("Q♥", 212, "🂽", "heart", "red", 12)
        ];

        $hand = new BlackjackCardHand($cards);

        $handActiveStatus = $hand->isHandActive();

        $this->assertTrue($handActiveStatus);

        $hand->updateHandStatus();

        $newHandActiveStatus = $hand->isHandActive();

        $this->assertTrue($newHandActiveStatus);

    }



}
