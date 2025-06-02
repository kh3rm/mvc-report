<?php

namespace App\Tests\BlackjackCardHand\TestModules;

use App\Card\Card;
use App\Blackjack\BlackjackCardHand\BlackjackCardHand;
use App\Deck\DeckOfCards52;
use App\Exception\HandNotSplittableException;

/**
 * Test cases for the class BlackjackCardHand.
 */
trait BlackjackCardHandSplitTest
{
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

        $this->expectException(HandNotSplittableException::class);

        $hand->splitHand($deck);

    }
}