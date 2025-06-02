<?php

namespace App\Tests\BlackjackCardHandling\TestModules;

use App\Card\Card;
use App\Blackjack\BlackjackCardHand\BlackjackCardHand;
use App\Blackjack\BlackjackPlayer\BlackjackPlayer;
use App\Exception\HandOutOfBoundsException;

/**
 * BJCardHandlingStandHandTest
 */
trait BJCardHandlingStandHandTest  {


    /**
     * Construct a BlackjackPlayer object and test that standing a hand marks it
     * as inactive.
     */
    public function testStandHand()
    {
        $cards = [
            new Card("8♣", 408, "🃘", "club", "black", 8),
            new Card("K♥", 213, "🂾", "heart", "red", 13)
        ];

        $hand = new BlackjackCardHand($cards);
        $player = new BlackjackPlayer("PlayerName", [$hand]);


        $player->standHand(0);

        $this->assertFalse($player->getHands()[0]->isHandActive());

    }


    /**
     * Construct a BlackjackPlayer object with one hand and assert that standing a
     * hand with invalid index throws a HandOutOfBoundsException.
     */
    public function testStandHandOutOfBounds()
    {
        $cards = [
            new Card("8♣", 408, "🃘", "club", "black", 8),
            new Card("K♥", 213, "🂾", "heart", "red", 13)
        ];

        $hand = new BlackjackCardHand($cards);
        $player = new BlackjackPlayer("PlayerName", [$hand]);

        $this->expectException(HandOutOfBoundsException::class);

        $player->standHand(1);

    }



    /**
     * Construct a BlackjackPlayer object with no hands and assert that standing a
     * non-existing hand throws a HandOutOfBoundsException.
     */
    public function testStandHandOutOfBoundsEmpty()
    {
        $player = new BlackjackPlayer("PlayerName", []);


        $this->expectException(HandOutOfBoundsException::class);

        $player->standHand(0);
    }


    /**
     * Construct a BlackjackPlayer object with one hand and assert that standing
     * with a negative index throws a HandOutOfBoundsException.
     */
    public function testStandHandNegativeIndex() {
        $cards = [
            new Card("8♣", 408, "🃘", "club", "black", 8),
            new Card("K♥", 213, "🂾", "heart", "red", 13)
        ];

        $hand = new BlackjackCardHand($cards);
        $player = new BlackjackPlayer("PlayerName", [$hand]);


        $this->expectException(HandOutOfBoundsException::class);

        $player->standHand(-1);
    }

};