<?php

namespace App\Tests\BlackjackGameResults\TestModules;

use App\Blackjack\BlackjackPlayer\BlackjackPlayer;
use App\Blackjack\BlackjackPlayer\BlackjackDealer;
use App\Blackjack\BlackjackGameResults\BlackjackGameResults;

trait BJGGRCreateDecidedTest
{
    /**
     * Construct GameResult-object using two arguments, a BlackjackPlayer ($player)
     * and a BlackjackDealer ($dealer), and ascertains that it is instantiated
     * correctly.
     */
    public function testCreateGameResults(): void
    {
        $player = new BlackjackPlayer("Player 1", []);
        $dealer = new BlackjackDealer([]);
        $gameResults = new BlackjackGameResults($player, $dealer);

        $this->assertInstanceOf(BlackjackGameResults::class, $gameResults);
    }

    /**
     * Construct GameResult-object with empty player/dealer-objects
     * (both have 1000 chips per default) and ascertains that the getGameDecided()-method
     * returns false (i.e, that both player/dealer has chips left).
     */
    public function testgetGameDecidedFalse(): void
    {
        $player = new BlackjackPlayer("Player 1", []);
        $dealer = new BlackjackDealer([]);
        $gameResults = new BlackjackGameResults($player, $dealer);

        $this->assertFalse($gameResults->getGameDecided());
    }

    /**
     * Construct GameResult-object with player/dealer-objects, where the player
     * has zero chips left, and ascertains that the getGameDecided()-method hence
     * returns true (dealer has won the game).
     */
    public function testGameDecidedWhenPlayerOutOfChips(): void
    {
        $player = new BlackjackPlayer("Player 1", [], 0);
        $dealer = new BlackjackDealer([], 2000);
        $gameResults = new BlackjackGameResults($player, $dealer);

        $gameResults->checkIfGameDecided();

        $this->assertTrue($gameResults->getGameDecided());
    }

    /**
     * Construct GameResult-object with player/dealer-objects, where the dealer
     * has zero chips left, and ascertains that the getGameDecided()-method hence
     * returns true (player has won the game).
     */
    public function testGameDecidedWhenDealerOutOfChips(): void
    {
        $player = new BlackjackPlayer("Player 1", [], 2000);
        $dealer = new BlackjackDealer([], 0);
        $gameResults = new BlackjackGameResults($player, $dealer);

        $gameResults->checkIfGameDecided();

        $this->assertTrue($gameResults->getGameDecided());
    }
}
