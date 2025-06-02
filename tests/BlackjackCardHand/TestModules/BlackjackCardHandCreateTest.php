<?php

namespace App\Tests\BlackjackCardHand\TestModules;

use App\Blackjack\BlackjackCardHand\BlackjackCardHand;
use App\Card\Card;


/**
 * Test cases for the class BlackjackCardHand.
 */
trait BlackjackCardHandCreateTest
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateBlackjackCardHand()
    {
        $hand = new BlackjackCardHand();
        $this->assertInstanceOf(BlackjackCardHand::class, $hand);
    }



    /**
     * Construct object with arguments and verify that the object has the expected
     * properties, and that the BlackjackCardHand contains only instances of Card.
     */
    public function testCreateWithArguments()
    {
        $cards = [new Card("8♣", 408, "🃘", "club", "black", 8)];
        $hand = new BlackjackCardHand($cards);
        $this->assertInstanceOf(BlackjackCardHand::class, $hand);

    }


}