<?php

namespace App\Tests\BlackjackPlayer\TestModules;

use App\Card\Card;
use App\Blackjack\BlackjackPlayer\BlackjackPlayer;
use App\Blackjack\BlackjackCardHand\BlackjackCardHand;

trait BlackjackPlayerCreateTest
{

    /**
     * Construct object using no arguments, and verify that an ArgumentCountError
     * is thrown when the two obligatory arguments, playerName and a $cardHands-array
     * is not supplied.
     */
    public function testCreateNoArguments()

    {
        $this->expectException(\ArgumentCountError::class);
        new BlackjackPlayer();

    }

    /**
     * Construct object using two arguments, a player name and an empty
     * $cardsHands-array.
     */
    public function testCreateNameNoHands()

    {

        $player = new BlackjackPlayer("PlayerName",[]);
        $this->assertInstanceOf(BlackjackPlayer::class, $player);
    }

    /**
     * Construct object using two arguments, a player name and a
     * $cardsHands-array containing one valid hand.
     */
    public function testCreateNameHand()

    {
        $cards = [new Card("8♣", 408, "🃘", "club", "black", 8)];
        $hand = new BlackjackCardHand($cards);

        $player = new BlackjackPlayer("PlayerName",[$hand]);
        $this->assertInstanceOf(BlackjackPlayer::class, $player);
    }

    /**
     * Construct object using two arguments, a player name and a $cardsHands-array
     * containing valid hands (2).
     */
    public function testCreateNameHands()

    {
        $cards = [
            new Card("8♣", 408, "🃘", "club", "black", 8),
            new Card("K♥", 213, "🂾", "heart", "red", 13)
        ];

        $hand = new BlackjackCardHand($cards);

        $player = new BlackjackPlayer("PlayerName",[$hand]);
        $this->assertInstanceOf(BlackjackPlayer::class, $player);
    }


    /**
     * Construct object and ascertain that the getPlayerName()-method works properly.
     */
    public function testGetPlayerName(): void
    {
        $player = new BlackjackPlayer("Player 1",[]);
        $this->assertSame('Player 1', $player->getPlayerName());
    }
}
