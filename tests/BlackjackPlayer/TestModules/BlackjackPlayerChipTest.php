<?php

namespace App\Tests\BlackjackPlayer\TestModules;

use App\Blackjack\BlackjackPlayer\BlackjackPlayer;

use App\Exception\NotEnoughChipsException;

trait BlackjackPlayerChipTest
{

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

        $this->expectException(NotEnoughChipsException::class);

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
}
