<?php

namespace App\Card;

use App\Exception\NotEnoughChipsException;
use PHPUnit\Framework\TestCase;

class BlackjackPlayerTest extends TestCase
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
        $this->assertInstanceOf("\App\Card\BlackjackPlayer", $player);
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
        $this->assertInstanceOf("\App\Card\BlackjackPlayer", $player);
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
        $this->assertInstanceOf("\App\Card\BlackjackPlayer", $player);
    }

    /**
     * Construct object and ascertain that the getPlayerName()-method works properly.
     */
    public function testGetPlayerName(): void
    {
        $player = new BlackjackPlayer("Player 1",[]);
        $this->assertSame('Player 1', $player->getPlayerName());
    }


    /**
     * Construct object and ascertain that the isActiveTurn()-method works properly,
     * and that the BlackjackPlayer is set to active per default. (When inactive/finished
     * the dealer's action commences in the gameplay.)
     */
    public function testIsActiveTurnDefaultTrue(): void
    {
        $player = new BlackjackPlayer("Player 1",[]);
        $this->assertTrue($player->isActiveTurn());
    }

    /**
     * Construct object and ascertain that the deactivateTurn()-method works properly,
     * and that it can change the BlackjackPlayer default status from activeTurn = true
     * to false.
     */
    public function testDeactivateTurn(): void
    {
        $player = new BlackjackPlayer("Player 1",[]);
        $this->assertTrue($player->isActiveTurn());

        $player->deactivateTurn();

        $this->assertFalse($player->isActiveTurn());
    }


    /**
     * Construct object and ascertain that the deactivateTurn()-method works properly,
     * and that it can change the BlackjackPlayer's deactivated turn (activeTurn = false)
     * to active again (activeTurn = true).
     */
    public function testActivateTurn(): void
    {
        $player = new BlackjackPlayer("Player 1",[]);
        $this->assertTrue($player->isActiveTurn());

        $player->deactivateTurn();

        $this->assertFalse($player->isActiveTurn());

        $player->activateTurn();

        $this->assertTrue($player->isActiveTurn());
    }


    /**
     * Construct object and ascertain that the getChipCount()-method works properly
     * with the default chip-amount.
     */
    public function testGetChipCount(): void
    {
        $player = new BlackjackPlayer("PlayerName",[]);
        $defaultChipCount = 1000;
        $this->assertSame($defaultChipCount, $player->getChipCount());
    }

    /**
     * Construct object and ascertain that the getChipCount()-method works properly
     * with a custom chip-amount.
     */
    public function testGetChipCountCustom(): void
    {
        $player = new BlackjackPlayer("PlayerName",[], 500);
        $setChipCount = 500;
        $this->assertSame($setChipCount, $player->getChipCount());
    }

    /**
     * Construct object and ascertain that the getChipCount-method works properly
     * with a custom zero chip-amount.
     */
    public function testGetChipCountCustomZero(): void
    {
        $player = new BlackjackPlayer("PlayerName",[], 0);
        $setChipCount = 0;
        $this->assertSame($setChipCount, $player->getChipCount());
    }

    /**
     * Construct object and ascertain that the wagerChips()-method works properly,
     * first with no chips (no change).
     */
    public function testWagerNoChips(): void
    {
        $player = new BlackjackPlayer("PlayerName",[]);

        $chipCount = $player->getChipCount();
        $player->wagerChips();
        $chipCountPostWager = $player->getChipCount();

        $this->assertSame($chipCount, $chipCountPostWager);
    }

    /**
     * Construct object and ascertain that the wagerChips()-method works properly
     * with specific valid amount.
     */
    public function testWagerChipsWithSpecificAmount(): void
    {
        $player = new BlackjackPlayer("PlayerName",[]);

        $player->wagerChips(200);

        $this->assertSame(800, $player->getChipCount());
    }

    /**
     * Construct object and ascertain a NotEnoughChipsException is thrown
     * when an amount that exceeds the chips available is wagered with
     * waterChips()-method.
     */
    public function testWagerNotEnoughChips(): void
    {
        $player = new BlackjackPlayer("PlayerName",[]);

        $this->expectException(\App\Exception\NotEnoughChipsException::class);

        $player->wagerChips(2000);
    }

    /**
     * Construct object and ascertain that the getChipsInPlayCount()-method works properly
     * with specific valid amount.
     */
    public function testgetChipsInPlayCount(): void
    {
        $player = new BlackjackPlayer("PlayerName",[]);

        $player->wagerChips(200);

        $this->assertSame(800, $player->getChipCount());
        $this->assertSame(200, $player->getChipsInPlayCount());
    }

     /**
     * Construct object and ascertain that the addChips()-method works properly
     * with specific valid amount.
     */
    public function testAddChips(): void
    {
        $player = new BlackjackPlayer("PlayerName",[]);
        $player->addChips(500);
        $this->assertSame(1500, $player->getChipCount());
    }

    /**
     * Construct object and ascertain that the addChips()-method works properly
     * with a zero amount (unchanged).
     */
    public function testAddChipsZero(): void
    {
        $player = new BlackjackPlayer("PlayerName",[]);
        $player->addChips(0);
        $this->assertSame(1000, $player->getChipCount());
    }

     /**
     * Construct object and ascertain that the testResetChipsInPlay()-method works properly,
     * by first wagering some chips, putting them into play, and making sure that it gets
     * reset when the method is exectudet. (Used at the end of a game round.)
     */
    public function testResetChipsInPlay(): void
    {
        $player = new BlackjackPlayer("PlayerName",[]);
        $player->wagerChips(100);

        $this->assertSame(100, $player->getChipsInPlayCount());

        $player->resetChipsInPlay();

        $this->assertSame(0, $player->getChipsInPlayCount());
    }


     /**
     * Construct object and ascertain that the testGetPlayerDetailsJson()-method works
     * properly, and that it returns the correctly formatted JSON-array.
     */
    public function testGetPlayerDetailsJsonEmptyHand(): void
    {
        $player = new BlackjackPlayer("PlayerName",[]);

        $this->expectException(\App\Exception\NoHandToRetrieveCardsException::class);

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
