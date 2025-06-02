<?php

namespace App\Tests\BlackjackCardHandling\TestModules;

use App\Card\Card;
use App\Blackjack\BlackjackCardHand\BlackjackCardHand;
use App\Blackjack\BlackjackPlayer\BlackjackPlayer;
use App\Exception\NoHandToRetrieveCardsException;

/**
 * BJCardHandlingUnicodeTest
 */
trait BJCardHandlingUnicodeTest  {

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

        $this->expectException(NoHandToRetrieveCardsException::class);

        $player->getCardsInHandAsUnicode();
}

};