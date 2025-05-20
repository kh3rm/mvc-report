<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

use App\Card\Card;

class BlackjackCardHandlingTest extends TestCase {

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

        $this->expectException(\App\Exception\HandOutOfBoundsException::class);

        $player->addCardToHand(0, $card);
    }

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

        $this->expectException(\App\Exception\HandOutOfBoundsException::class);

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

        $this->expectException(\App\Exception\HandNotSplittableException::class);

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

        $this->expectException(\App\Exception\HandNotSplittableException::class);

        $player->splitHand(0, $deck);
    }



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

        $this->expectException(\App\Exception\HandOutOfBoundsException::class);

        $player->standHand(1);

    }



    /**
     * Construct a BlackjackPlayer object with no hands and assert that standing a
     * non-existing hand throws a HandOutOfBoundsException.
     */
    public function testStandHandOutOfBoundsEmpty()
    {
        $player = new BlackjackPlayer("PlayerName", []);


        $this->expectException(\App\Exception\HandOutOfBoundsException::class);

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


        $this->expectException(\App\Exception\HandOutOfBoundsException::class);

        $player->standHand(-1);
    }



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


    /**
     * Construct a BlackjackPlayer object with a hand containing cards and
     * test that the getCardsInHandAsUnicode() method returns the correct Unicode representation.
     */
    public function testGetCardsInHandAsUnicode()
    {
        $cards = [
            new Card("8♣", 408, "🃘", "club", "black", 8),
            new Card("K♥", 213, "🂾", "heart", "red", 13),
            new Card("A♠", 114, "🂡", "spade", "black", 14)
        ];

        $hand = new BlackjackCardHand($cards);
        $player = new BlackjackPlayer("PlayerName", [$hand]);

        $unicodeRepr = $player->getCardsInHandAsUnicode();


        $expectedUnicode= "🃘🂾🂡";

        $this->assertEquals($expectedUnicode, $unicodeRepr);
    }


    /**
     * Construct a BlackjackPlayer object with no hands and test that calling the
     * getCardsInHandAsUnicode()-method throws a NoHandToRetrieveCardsException.
     */
    public function testGetCardsInHandAsUnicodeNoHands()
    {

        $player = new BlackjackPlayer("PlayerName", []);

        $this->expectException(\App\Exception\NoHandToRetrieveCardsException::class);

        $player->getCardsInHandAsUnicode();
}

};