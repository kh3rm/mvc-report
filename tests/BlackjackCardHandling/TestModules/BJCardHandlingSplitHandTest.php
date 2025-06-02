<?php

namespace App\Tests\BlackjackCardHandling\TestModules;

use PHPUnit\Framework\TestCase;

use App\Card\Card;
use App\Blackjack\BlackjackCardHand\BlackjackCardHand;
use App\Blackjack\BlackjackPlayer\BlackjackPlayer;
use App\Deck\DeckOfCards52;
use App\Exception\HandOutOfBoundsException;
use App\Exception\HandNotSplittableException;

/**
 * BJCardHandlingSplitHandTest
 */
trait BJCardHandlingSplitHandTest {

    /**
     * Construct a BlackjackPlayer object with a BlackjackCardHand consisting of two
     * splittable facecards and ascertain that the splitPlayerHandInvalid()-method works
     * properly and splits them, and that the player now has two BlackjackCardHands.
     */
    public function testSplitPlayerHand() {
        $cards = [
            new Card("K♥", 213, "🂾", "heart", "red", 13),
            new Card("Q♥", 212, "🂽", "heart", "red", 12)
        ];

        $initialHand = new BlackjackCardHand($cards);
        $player = new BlackjackPlayer("PlayerName", []);
        $player->addHands($initialHand);

        $deck = new DeckOfCards52();

        $this->assertCount(1, $player->getHands());

        $player->splitHand(0, $deck);

        $this->assertCount(2, $player->getHands());
    }


    /**
     * Construct a BlackjackPlayer object with a BlackjackCardHand consisting of two
     * splittable facecards and ascertain that the splitPlayerHandInvalid()-method
     * throws an HandOutOfBoundsException when provided with an invalid negative
     * index.
     */
    public function testSplitPlayerHandNegativeIndex() {
        $cards = [
            new Card("K♥", 213, "🂾", "heart", "red", 13),
            new Card("Q♥", 212, "🂽", "heart", "red", 12)
        ];

        $initialHand = new BlackjackCardHand($cards);
        $player = new BlackjackPlayer("PlayerName", []);
        $player->addHands($initialHand);

        $deck = new DeckOfCards52();

        $this->assertCount(1, $player->getHands());

        $this->expectException(HandOutOfBoundsException::class);

        $player->splitHand(-1, $deck);

    }




    /**
     * Construct a BlackjackPlayer object with a BlackjackCardHand consisting of two
     * non-splittable cards and ascertain that the splitPlayerHandInvalid()-method works
     * properly and throws a HandNotSplittableException when trying to split them.
     */
    public function testSplitPlayerHandInvalid() {
        $cards = [
            new Card("8♣", 408, "🃘", "club", "black", 8),
            new Card("K♥", 213, "🂾", "heart", "red", 13)
        ];


        $initialHand = new BlackjackCardHand($cards);
        $player = new BlackjackPlayer("PlayerName", []);
        $player->addHands($initialHand);

        $deck = new DeckOfCards52();

        $this->expectException(HandNotSplittableException::class);

        $player->splitHand(0, $deck);

    }

    /**
     * Construct a BlackjackPlayer object with a BlackjackCardHand consisting of two cards,
     * mark the hand as inactive using the standHand method, and ascertain that trying to split
     * the hand throws a HandNotSplittableException.
     */
    public function testSplitInactiveHand()
    {
        $cards = [
            new Card("8♣", 408, "🃘", "club", "black", 8),
            new Card("K♥", 213, "🂾", "heart", "red", 13)
        ];

        $initialHand = new BlackjackCardHand($cards);
        $player = new BlackjackPlayer("PlayerName", []);

        $player->addHands($initialHand);

        $player->standHand(0);

        $deck = new DeckOfCards52();

        $this->expectException(HandNotSplittableException::class);

        $player->splitHand(0, $deck);
    }
};