<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

use App\Card\Card;

// use App\Exception\ExcessiveDiceValueException;

/**
 * Test cases for the class DeckOfCards52.
 */
class DeckOfCards52Test extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateDeckOfCards52()
    {
        $deck = new DeckOfCards52();
        $this->assertInstanceOf("\App\Card\DeckOfCards52", $deck);
        $this->assertNotEmpty($deck);
    }

    /**
     * Construct object and verify that the object's retrieved cards only containes
     * instances of Card, also confirming that the getCards() is functioning properly.
     *
     */
    public function testCreateDeckOfCards52Complete()
    {
        $deck = new DeckOfCards52();
        $this->assertInstanceOf("\App\Card\DeckOfCards52", $deck);
        $cardsInDeck = $deck->getCards();
        $this->assertContainsOnlyInstancesOf(Card::class, $cardsInDeck);
        $this->assertCount(52, $cardsInDeck);
    }


    /**
     * Construct an empty deck (by feeding the constructor a false boolean) and verify
     * that the object's retrieved cards is empty.
     *
     */
    public function testCreateDeckOfCardsEmpty()
    {
        $deck = new DeckOfCards52(false);
        $deck->emptyDeck();
        $this->assertInstanceOf("\App\Card\DeckOfCards", $deck);
        $cardsInDeck = $deck->getCards();
        $this->assertCount(0, $cardsInDeck);
    }


    /**
     * Construct object and verify that the object's retrieved cards only contains
     * instances of playable cards, i.e that the jokers has been removed, which is the
     * hallmark of this class, and the only thing that differentiates it from the parent
     * DeckOfCard-cass. The jokers are assigned an int-value of 0, which is what
     * this test uses to ascertain that they have been removed.
     *
     */
    public function testJokersAreRemoved()
    {
        $deck = new DeckOfCards52(true);
        $cards = $deck->getCards();
        foreach ($cards as $card) {
            $this->assertNotEquals(0, $card->getCardAsInt());
        }
        $cardsInDeck = $deck->getCards();
        $this->assertCount(52, $cardsInDeck);


}
}
