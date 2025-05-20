<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;
use App\Exception\NotEnoughChipsException;

class BlackjackDealerTest extends TestCase
{
    /**
     * Construct object using no arguments, and verify that an ArgumentCountError
     * is thrown when the required arguments, an array of cardHands, are not supplied.
     */
    public function testCreateNoArguments()
    {
        $this->expectException(\ArgumentCountError::class);
        new BlackjackDealer();
    }

    /**
     * Construct object using a valid cardsHand array and assert that an instance
     * of BlackjackDealer is created properly.
     */
    public function testCreateNameNoHands()
    {
        $dealer = new BlackjackDealer([]);
        $this->assertInstanceOf(BlackjackDealer::class, $dealer);
    }

    /**
     * Construct object with one valid hand and verify that it is an instance
     * of BlackjackDealer.
     */
    public function testCreateWithOneHand()
    {
        $card = new Card("8♣", 408, "🃘", "club", "black", 8);
        $hand = new BlackjackCardHand([$card]);

        $dealer = new BlackjackDealer([$hand]);
        $this->assertInstanceOf(BlackjackDealer::class, $dealer);

    }
}