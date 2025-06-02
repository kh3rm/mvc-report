<?php

namespace App\Tests\BlackjackCardHandling\TestModules;


use App\Card\Card;
use App\Blackjack\BlackjackCardHand\BlackjackCardHand;
use App\Blackjack\BlackjackPlayer\BlackjackPlayer;

/**
 * BJCardHandlingHandStatusTest
 */
trait BJCardHandlingHandStatusTest {


    /**
     * Construct a BlackjackPlayer object and test that the updateHandsStatus() method
     * correctly updates (keeps) the status of a hand with a total value under 21 as active.
     */
    public function testUpdateHandStatusActive() {
        $cards = [
            new Card("8♣", 408, "🃘", "club", "black", 8),
            new Card("K♥", 213, "🂾", "heart", "red", 13)
        ];

        $hand = new BlackjackCardHand($cards);
        $player = new BlackjackPlayer("PlayerName", []);
        $player->addHands($hand);
        $player->updateHandsStatus();

        $playerHand = $player->getHands();
        $playerHandActive = $playerHand[0]->isHandActive();

        $this->assertTrue($playerHandActive);
    }

    /**
     * Construct a BlackjackPlayer object and test that the updateHandsStatus() method
     * correctly updates the status of a hand with a total value over 21 to inactive (bust).
     */
    public function testUpdateHandStatusBust()
    {
        $cards = [
            new Card("K♥", 213, "🂾", "heart", "red", 13),
            new Card("A♥", 214, "🂱", "heart", "red", 14),
            new Card("8♣", 408, "🃘", "club", "black", 8),
            new Card("Q♥", 212, "🂽", "heart", "red", 12)
        ];

        $hand = new BlackjackCardHand($cards);
        $player = new BlackjackPlayer("PlayerName", []);
        $player->addHands($hand);
        $player->updateHandsStatus();

        $playerHand = $player->getHands();
        $playerHandActive = $playerHand[0]->isHandActive();

        $this->assertFalse($playerHandActive);

    }

    /**
     * Construct a BlackjackPlayer object and test that the updateHandsStatus() method
     * correctly updates the status of a hand with a total value of 21 to inactive
     * according to the game rules for blackjack.
     */
    public function testUpdateHandStatus21()
    {
        $cards = [
            new Card("K♥", 213, "🂾", "heart", "red", 13),
            new Card("A♥", 214, "🂱", "heart", "red", 14)
        ];

        $hand = new BlackjackCardHand($cards);
        $player = new BlackjackPlayer("PlayerName", []);
        $player->addHands($hand);
        $player->updateHandsStatus();

        $playerHand = $player->getHands();
        $playerHandActive = $playerHand[0]->isHandActive();

        $this->assertFalse($playerHandActive);
    }



    /**
     * Construct a BlackjackPlayer object and test that the activeHandsCount()-method returns
     * the correct count (1) of active hands for a player for the one active hand added.
     */
    public function testActiveHandsCount() {
        $cards = [
            new Card("8♣", 408, "🃘", "club", "black", 8),
            new Card("K♥", 213, "🂾", "heart", "red", 13)
        ];

        $hand = new BlackjackCardHand($cards);
        $player = new BlackjackPlayer("PlayerName", []);
        $player->addHands($hand);
        $player->updateHandsStatus();

        $this->assertSame(1, $player->activeHandsCount());
    }


    /**
     * Construct a BlackjackPlayer object and test that the activeHandsCount()-method returns
     * the correct count (1) of active hands for a player when an empty hand is added.
     *
     * (It's a semantic question not really relevant for the actual game implementation, as
     * two cards is dealt per default in my blackjack-implementation, but since the hand is
     * under 21, and has not been deactivated, it is technically active.)
     *
     */
    public function testActiveHandsCountZero() {


        $hand = new BlackjackCardHand();
        $player = new BlackjackPlayer("PlayerName", []);
        $player->addHands($hand);
        $player->updateHandsStatus();

        $this->assertSame(1, $player->activeHandsCount());
    }


    /**
     * Construct a BlackjackPlayer object and test that the activeHandsCount()-method returns
     * the correct count (0) of active hands for a player when an hand of 21 is added..
     *
     *
     */
    public function testActiveHandsCount21() {
        $cards = [
            new Card("K♥", 213, "🂾", "heart", "red", 13),
            new Card("A♥", 214, "🂱", "heart", "red", 14)
        ];

        $hand = new BlackjackCardHand($cards);
        $player = new BlackjackPlayer("PlayerName", []);
        $player->addHands($hand);
        $player->updateHandsStatus();

        $this->assertSame(0, $player->activeHandsCount());
    }



    /**
     * Construct a BlackjackPlayer object and test that the activeHandsCount()-method returns
     * the correct count (0) of active hands for a player when an hand with a value above 21
     * is added (busted hand).
     *
     */
    public function testActiveHandsCountBust() {
        $cards = [
            new Card("K♥", 213, "🂾", "heart", "red", 13),
            new Card("A♥", 214, "🂱", "heart", "red", 14),
            new Card("8♣", 408, "🃘", "club", "black", 8),
            new Card("Q♥", 212, "🂽", "heart", "red", 12)
        ];

        $hand = new BlackjackCardHand($cards);
        $player = new BlackjackPlayer("PlayerName", []);
        $player->addHands($hand);
        $player->updateHandsStatus();

        $this->assertSame(0, $player->activeHandsCount());
    }

};