<?php

namespace App\Tests\BlackjackCardHandling\TestModules;

use App\Card\Card;
use App\Blackjack\BlackjackCardHand\BlackjackCardHand;
use App\Blackjack\BlackjackPlayer\BlackjackPlayer;
use App\Exception\HandOutOfBoundsException;

/**
 * BJCardHandlingGetAddHandTest
 */
trait BJCardHandlingGetAddHandTest {
  /**
     * Construct a BlackjackPlayer-object with an empty array as an argument
     * for cardHands, and assert that the getCards returns an empty array.
     */
    public function testGetHands() {
        $player = new BlackjackPlayer("PlayerName", []);
        $this->assertEmpty($player->getHands());
    }



    /**
     * Construct a BlackjackPlayer object and add a new empty hand using the
     * addHands()-method, and asser that it now has one hand and that is of
     * the type BlackjackCardHand.
     */
    public function testAddHandsEmpty() {

        $hand = new BlackjackCardHand([]);
        $player = new BlackjackPlayer("PlayerName", []);
        $player->addHands($hand);
        $handsInHand = $player->getHands();
        $this->assertCount(1, $handsInHand);

        foreach ($handsInHand as $hand) {
            $this->assertInstanceOf(BlackjackCardHand::class, $hand);
        }

    }


    /**
     * Construct a BlackjackPlayer object with no hand(s), and
     * ascertain that the handsCount()-method is returning the correct
     * hand count (0).
     */
    public function testhandsCountNone() {
        $player = new BlackjackPlayer("PlayerName", []);
        $handsInHand = count($player->getHands());
        $playerHandCount = $player->handsCount();

        $this->assertEquals($playerHandCount, $handsInHand, 0);

    }


    /**
     * Construct a BlackjackPlayer object with one hand, and
     * ascertain that the handsCount()-method is returning the correct
     * hand count (1).
     */
    public function testhandsCount() {
        $cards = [
            new Card("8♣", 408, "🃘", "club", "black", 8),
            new Card("K♥", 213, "🂾", "heart", "red", 13)
        ];

        $hand = new BlackjackCardHand($cards);

        $player = new BlackjackPlayer("PlayerName",[$hand]);

        $handsInHand = count($player->getHands());
        $playerHandCount = $player->handsCount();

        $this->assertEquals($playerHandCount, $handsInHand, 1);

    }



    /**
     * Construct a BlackjackPlayer object and add a hand with two cards using
     * the addHands()-method and assert that it now has one hand and that is of
     * the type BlackjackCardHand.
     */
    public function testAddHands() {

        $cards = [
            new Card("8♣", 408, "🃘", "club", "black", 8),
            new Card("K♥", 213, "🂾", "heart", "red", 13)
        ];

        $hand = new BlackjackCardHand($cards);

        $player = new BlackjackPlayer("PlayerName",[$hand]);

        $player->addHands($hand);
        $handsInHand = $player->getHands();
        $this->assertCount(2, $handsInHand);

        foreach ($handsInHand as $hand) {
            $this->assertInstanceOf(BlackjackCardHand::class, $hand);
        }

    }


    /**
     * Construct a BlackjackPlayer object and add a hand using the addHands()-method
     * that is not of the type BlackjackCardHand, and ascertain that a type-error is thrown.
     */
    public function testAddHandsInvalid() {

        $hand = ["NoBlackjackCardHandObject"];
        $player = new BlackjackPlayer("PlayerName", []);

        $this->expectException(\TypeError::class);

        $player->addHands($hand);
    }


    /**
     * Construct a BlackjackPlayer object with a two card BlackjackCardHand, and add another card
     * using the addCardToHand()-method, and ascertain that it has been added properly.
     */
    public function testAddCardToPlayerHand() {

        $cards = [
            new Card("8♣", 408, "🃘", "club", "black", 8),
            new Card("K♥", 213, "🂾", "heart", "red", 13)
        ];

        $hand = new BlackjackCardHand($cards);

        $player = new BlackjackPlayer("PlayerName", [$hand]);

        $newCard = new Card("8♣", 408, "🃘", "club", "black", 8);

        $player->addCardToHand(0, $newCard);

        $this->assertCount(3, $player->getHands()[0]->getCards());
    }




    /**
     * Test that HandOutOfBoundsException is thrown when adding a card to a non-existing hand.
     */
    public function testAddCardToHandWhenNoHand() {
        $card = new Card("8♣", 408, "🃘", "club", "black", 8);
        $player = new BlackjackPlayer("PlayerName", []);

        $this->expectException(HandOutOfBoundsException::class);

        $player->addCardToHand(0, $card);
    }

};