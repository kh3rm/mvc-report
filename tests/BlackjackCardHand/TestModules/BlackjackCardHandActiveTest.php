<?php

namespace App\Tests\BlackjackCardHand\TestModules;

use App\Blackjack\BlackjackCardHand\BlackjackCardHand;


/**
 * Test cases for the class BlackjackCardHand.
 */
trait BlackjackCardHandActiveTest
{
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
}