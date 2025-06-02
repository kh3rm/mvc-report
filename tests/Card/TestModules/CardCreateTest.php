<?php

namespace App\Tests\Card\TestModules;

use App\Card\Card;

/**
 * CardCreateTest
 */
trait CardCreateTest
{
    /**
     * Tests that creating a Card without any arguments throws the expected ArgumentCountError.
     */
    public function testCreateCardNoArguments()
    {
        $this->expectException(\ArgumentCountError::class);
        new Card();
    }

    /**
     * Tests that creating a Card with non-type-matching arguments throws the expected TypeError.
     */
    public function testCreateCardInvalidArguments()
    {
        $this->expectException(\TypeError::class);
        new Card(1, "faulty", "arguments", 99,
         "supplied", "typerror");
    }

    /**
     * Tests that creating a Card with too few arguments throws the expected TypeError.
     */
    public function testCreateCardInsufficientArguments()
    {
        $this->expectException(\TypeError::class);
        new Card("none", 99);
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
}