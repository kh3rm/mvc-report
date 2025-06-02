<?php

namespace App\Tests\BlackjackCardHandling\TestModules;

use App\Card\Card;
use App\Blackjack\BlackjackCardHand\BlackjackCardHand;
use App\Blackjack\BlackjackPlayer\BlackjackPlayer;

/**
 * BJCardHandlingTurnStatusResetTest
 */
trait BJCardHandlingTurnStatusResetTest {

    /**
     * Construct a BlackjackPlayer object and test that the testactiveTurnStatus()-method
     * leaves the player's status as active when there are active hands remaining in hand.
     *
     */
    public function testactiveTurnStatusUnchanged() {
        $cardsOne = [
            new Card("K♥", 213, "🂾", "heart", "red", 13),
            new Card("A♥", 214, "🂱", "heart", "red", 14),
            new Card("8♣", 408, "🃘", "club", "black", 8),
            new Card("Q♥", 212, "🂽", "heart", "red", 12)
        ];

        $cardsTwo = [
            new Card("K♥", 213, "🂾", "heart", "red", 13),
            new Card("A♥", 214, "🂱", "heart", "red", 14)
        ];

        $cardsThree = [
            new Card("8♣", 408, "🃘", "club", "black", 8),
            new Card("K♥", 213, "🂾", "heart", "red", 13)
        ];


        $handOne = new BlackjackCardHand($cardsOne);
        $handTwo = new BlackjackCardHand($cardsTwo);
        $handThree = new BlackjackCardHand($cardsThree);


        $player = new BlackjackPlayer("PlayerName", [$handOne, $handTwo, $handThree]);

        $player->updateHandsStatus();

        $player->activeTurnStatus();

        $this->assertTrue($player->isActiveTurn());
    }


    /**
     * Construct a BlackjackPlayer object and test that the testactiveTurnStatus()-method
     * updates the player's status t inactive when there are no active hands remaining in hand.
     *
     */
    public function testactiveTurnStatusChanged() {
        $cardsOne = [
            new Card("K♥", 213, "🂾", "heart", "red", 13),
            new Card("A♥", 214, "🂱", "heart", "red", 14),
            new Card("8♣", 408, "🃘", "club", "black", 8),
            new Card("Q♥", 212, "🂽", "heart", "red", 12)
        ];

        $cardsTwo = [
            new Card("K♥", 213, "🂾", "heart", "red", 13),
            new Card("A♥", 214, "🂱", "heart", "red", 14)
        ];



        $handOne = new BlackjackCardHand($cardsOne);
        $handTwo = new BlackjackCardHand($cardsTwo);


        $player = new BlackjackPlayer("PlayerName", [$handOne, $handTwo]);

        $player->updateHandsStatus();

        $player->activeTurnStatus();

        $this->assertFalse($player->isActiveTurn());
    }



    /**
     * Construct a BlackjackPlayer object with three example hands, and test that the
     * resetHands()-method clears out the hands and leaves the player's hand empty.
     *
     */
    public function testResetHands() {
        $cardsOne = [
            new Card("K♥", 213, "🂾", "heart", "red", 13),
            new Card("A♥", 214, "🂱", "heart", "red", 14),
            new Card("8♣", 408, "🃘", "club", "black", 8),
            new Card("Q♥", 212, "🂽", "heart", "red", 12)
        ];

        $cardsTwo = [
            new Card("K♥", 213, "🂾", "heart", "red", 13),
            new Card("A♥", 214, "🂱", "heart", "red", 14)
        ];

        $cardsThree = [
            new Card("8♣", 408, "🃘", "club", "black", 8),
            new Card("K♥", 213, "🂾", "heart", "red", 13)
        ];


        $handOne = new BlackjackCardHand($cardsOne);
        $handTwo = new BlackjackCardHand($cardsTwo);
        $handThree = new BlackjackCardHand($cardsThree);


        $player = new BlackjackPlayer("PlayerName", [$handOne, $handTwo, $handThree]);

        $handsInHand = $player->getHands();
        $this->assertCount(3, $handsInHand);

        foreach ($handsInHand as $hand) {
            $this->assertInstanceOf(BlackjackCardHand::class, $hand);
        }

        $player->resetHands();

        $handsInHand = $player->getHands();

        $this->assertCount(0, $handsInHand);

        $this->assertEmpty($handsInHand);
    }


};