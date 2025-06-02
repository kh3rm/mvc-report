<?php

namespace App\Tests\BlackjackPlayer\TestModules;

use App\Blackjack\BlackjackPlayer\BlackjackPlayer;

trait BlackjackPlayerTurnTest
{
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
}
