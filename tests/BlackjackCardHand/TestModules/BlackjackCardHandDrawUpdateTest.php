<?php

namespace App\Tests\BlackjackCardHand\TestModules;

use App\Blackjack\BlackjackCardHand\BlackjackCardHand;
use App\Card\Card;
use App\Deck\DeckOfCards52;


/**
 * Test cases for the class BlackjackCardHand.
 */
trait BlackjackCardHandDrawUpdateTest
{
    /**
     * Construct empty BlackjackCardHand and DeckOfCards52, add a card to the deck,
     * and test that the method drawCardFromDeck() correctly draws that card from the
     * supplied deck.
     */
    public function testDrawCardFromDeck()
    {
        $card = new Card("A♥", 214, "🂱", "heart", "red", 14);

        $deckOfCards52 = new DeckOfCards52();

        $deckOfCards52->emptyDeck();

        $deckOfCards52->addCard($card);

        $this->assertCount(1, $deckOfCards52->getCards());

        $hand = new BlackjackCardHand();



        $this->assertCount(0, $hand->getCards());

        $hand->drawCardFromDeck($deckOfCards52);

        $this->assertCount(1, $hand->getCards());
    }


    /**
     * Construct a hand with the value 21 (blackjack), and ascertain that the
     * updateHandStatus()-method works properly, i.e, updates the hand active
     * value to false.
     */
    public function testUpdateHandStatus21()
    {
        $cards = [
            new Card("K♥", 213, "🂾", "heart", "red", 13),
            new Card("A♥", 214, "🂱", "heart", "red", 14)
        ];

        $hand = new BlackjackCardHand($cards);

        $handActiveStatus = $hand->isHandActive();

        $this->assertTrue($handActiveStatus);

        $hand->updateHandStatus();

        $newHandActiveStatus = $hand->isHandActive();

        $this->assertFalse($newHandActiveStatus);

    }

    /**
     * Construct a hand with a value under 21 , and ascertain that the
     * updateHandStatus()-method works properly, i.e, that the hand status is
     * active also after update.
     */
    public function testUpdateHandStatusSub21()
    {
        $cards = [
            new Card("K♥", 213, "🂾", "heart", "red", 13),
            new Card("Q♥", 212, "🂽", "heart", "red", 12)
        ];

        $hand = new BlackjackCardHand($cards);

        $handActiveStatus = $hand->isHandActive();

        $this->assertTrue($handActiveStatus);

        $hand->updateHandStatus();

        $newHandActiveStatus = $hand->isHandActive();

        $this->assertTrue($newHandActiveStatus);

    }
}