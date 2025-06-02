<?php

namespace App\Tests\BlackjackPlayer\TestModules;

use App\Card\Card;
use App\Blackjack\BlackjackPlayer\BlackjackPlayer;
use App\Blackjack\BlackjackCardHand\BlackjackCardHand;

use App\Exception\NoHandToRetrieveCardsException;

trait BlackjackPlayerJsonTest
{

     /**
     * Construct object and ascertain that the testGetPlayerDetailsJson()-method works
     * properly, and that it returns the correctly formatted JSON-array.
     */
    public function testGetPlayerDetailsJsonEmptyHand(): void
    {
        $player = new BlackjackPlayer("PlayerName",[]);

        $this->expectException(NoHandToRetrieveCardsException::class);

        $player->getPlayerDetailsJson();
    }



    /**
     * Construct object and ascertain that the testGetPlayerDetailsJson()-method works
     * properly, and that it returns the correctly formatted JSON-array.
     */
    public function testGetPlayerDetailsJsonValidHand(): void
    {
        $cards = [
            new Card("8♣", 408, "🃘", "club", "black", 8),
            new Card("K♥", 213, "🂾", "heart", "red", 13)
        ];

        $hand = new BlackjackCardHand($cards);

        $player = new BlackjackPlayer("PlayerName",[$hand]);

        $expectedJson = [
            'playerName' => 'PlayerName',
            'playerHandUnicode' => $player->getCardsInHandAsUnicode(),
            'chipsStatus' => 'Chips: 1000 (+0 in play)',
        ];

        $this->assertSame($expectedJson, $player->getPlayerDetailsJson());
    }

}
