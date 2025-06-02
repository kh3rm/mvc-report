<?php

namespace App\Tests\BlackjackGameResults\TestModules;

use App\Card\Card;
use App\Blackjack\BlackjackPlayer\BlackjackPlayer;
use App\Blackjack\BlackjackPlayer\BlackjackDealer;
use App\Blackjack\BlackjackCardHand\BlackjackCardHand;
use App\Blackjack\BlackjackGameResults\BlackjackGameResults;

trait BJGGRRoundTest
{
    /**
     * Constructs a GameResult-object with player/dealer-objects, where the player wins
     * because the dealer has a bust hand, and ascertains that the correct results
     * are returned and that the updated chip counts are accurate.
     */
    public function testPlayerWinsRoundDealerBust(): void
    {
        $playerCards = [
            new Card("8♣", 408, "🃘", "club", "black", 8),
            new Card("K♥", 213, "🂾", "heart", "red", 13)
        ];

        $dealerCards = [
            new Card("K♥", 213, "🂾", "heart", "red", 13),
            new Card("A♥", 214, "🂱", "heart", "red", 14),
            new Card("8♣", 408, "🃘", "club", "black", 8),
            new Card("Q♥", 212, "🂽", "heart", "red", 12)
        ];

        $playerHand = new BlackjackCardHand($playerCards);
        $dealerHand = new BlackjackCardHand($dealerCards);


        $player = new BlackjackPlayer("Player 1", [$playerHand]);
        $dealer = new BlackjackDealer([$dealerHand]);

        $player->wagerChips(100);
        $dealer->wagerChips(100);

        $gameResult = new BlackjackGameResults($player, $dealer);
        $roundResult = $gameResult->decideBlackjackRoundResults();

        $this->assertStringContainsString('Round Results: Player 1: +100, Dealer: -100.', $roundResult['round-results']);
        $this->assertEquals(1100, $player->getChipCount());
        $this->assertEquals(900, $dealer->getChipCount());
    }


    /**
     * Constructs a GameResult-object with player/dealer-objects, where the player wins
     * because the dealer has a lower hand, and ascertains that the correct results
     * are returned and that the updated chip counts are accurate.
     */
    public function testPlayerWinsRoundDealerLower(): void
    {
        $playerCards = [
            new Card("Q♥", 212, "🂽", "heart", "red", 12),
            new Card("K♥", 213, "🂾", "heart", "red", 13)
        ];

        $dealerCards = [
            new Card("K♠", 113, "🂮", "spade", "black", 13),
            new Card("8♣", 408, "🃘", "club", "black", 8),

        ];

        $playerHand = new BlackjackCardHand($playerCards);
        $dealerHand = new BlackjackCardHand($dealerCards);


        $player = new BlackjackPlayer("Player 1", [$playerHand]);
        $dealer = new BlackjackDealer([$dealerHand]);

        $player->wagerChips(100);
        $dealer->wagerChips(100);

        $gameResult = new BlackjackGameResults($player, $dealer);
        $roundResult = $gameResult->decideBlackjackRoundResults();

        $this->assertStringContainsString('Round Results: Player 1: +100, Dealer: -100.', $roundResult['round-results']);
        $this->assertEquals(1100, $player->getChipCount());
        $this->assertEquals(900, $dealer->getChipCount());
    }




    /**
     * Constructs a GameResult-object with player/dealer-objects, where the dealer wins
     * because the player has a bust hand, and ascertains that the correct results
     * are returned and that the updated chip counts are accurate.
     */
    public function testDealerWinsRoundPlayerBust(): void
    {
        $dealerCards = [
            new Card("8♣", 408, "🃘", "club", "black", 8),
            new Card("K♥", 213, "🂾", "heart", "red", 13)
        ];

        $playerCards = [
            new Card("K♥", 213, "🂾", "heart", "red", 13),
            new Card("A♥", 214, "🂱", "heart", "red", 14),
            new Card("8♣", 408, "🃘", "club", "black", 8),
            new Card("Q♥", 212, "🂽", "heart", "red", 12)
        ];

        $playerHand = new BlackjackCardHand($playerCards);
        $dealerHand = new BlackjackCardHand($dealerCards);


        $player = new BlackjackPlayer("Player 1", [$playerHand]);
        $dealer = new BlackjackDealer([$dealerHand]);

        $player->wagerChips(100);
        $dealer->wagerChips(100);

        $gameResult = new BlackjackGameResults($player, $dealer);
        $roundResult = $gameResult->decideBlackjackRoundResults();

        $this->assertStringContainsString('Round Results: Player 1: -100, Dealer: +100.', $roundResult['round-results']);
        $this->assertEquals(900, $player->getChipCount());
        $this->assertEquals(1100, $dealer->getChipCount());
    }



    /**
     * Constructs a GameResult-object with player/dealer-objects, where the dealer wins
     * because the player has a lower hand, and ascertains that the correct results
     * are returned and that the updated chip counts are accurate.
     */
    public function testDealerWinsRoundPlayerLower(): void
    {
        $dealerCards = [
            new Card("Q♥", 212, "🂽", "heart", "red", 12),
            new Card("K♥", 213, "🂾", "heart", "red", 13)
        ];

        $playerCards = [
            new Card("K♠", 113, "🂮", "spade", "black", 13),
            new Card("8♣", 408, "🃘", "club", "black", 8),

        ];

        $playerHand = new BlackjackCardHand($playerCards);
        $dealerHand = new BlackjackCardHand($dealerCards);


        $player = new BlackjackPlayer("Player 1", [$playerHand]);
        $dealer = new BlackjackDealer([$dealerHand]);

        $player->wagerChips(100);
        $dealer->wagerChips(100);

        $gameResult = new BlackjackGameResults($player, $dealer);
        $roundResult = $gameResult->decideBlackjackRoundResults();

        $this->assertStringContainsString('Round Results: Player 1: -100, Dealer: +100.', $roundResult['round-results']);
        $this->assertEquals(900, $player->getChipCount());
        $this->assertEquals(1100, $dealer->getChipCount());
    }


    /**
     * Construct a GameResult-object with player/dealer-objects, where the round
     * ends in a draw, and ascertains that the correct results are returned with no
     * changes to the chip counts.
     */
    public function testDrawnRound(): void
    {
        $dealerCards = [
            new Card("8♣", 408, "🃘", "club", "black", 8),
            new Card("K♥", 213, "🂾", "heart", "red", 13)
        ];

        $playerCards = [
            new Card("8♠", 108, "🂨", "spade", "black", 8),
            new Card("Q♥", 212, "🂽", "heart", "red", 12)
        ];

        $playerHand = new BlackjackCardHand($playerCards);
        $dealerHand = new BlackjackCardHand($dealerCards);


        $player = new BlackjackPlayer("Player 1", [$playerHand]);
        $dealer = new BlackjackDealer([$dealerHand]);

        $player->wagerChips(100);
        $dealer->wagerChips(100);

        $gameResult = new BlackjackGameResults($player, $dealer);
        $roundResult = $gameResult->decideBlackjackRoundResults();

        $this->assertStringContainsString('Round Results: Player 1: +0, Dealer: +0', $roundResult['round-results']);
        $this->assertEquals(1000, $player->getChipCount());
        $this->assertEquals(1000, $dealer->getChipCount());
    }




    /**
     * Construct a GameResult-object with player/dealer-objects, where the round
     * ends in a draw as both the player and dealer are bust, and ascertains that
     * the correct results are returned with no changes to the chip counts.
     */
    public function testDrawnRoundBothBust(): void
    {
        $dealerCards = [
            new Card("8♣", 408, "🃘", "club", "black", 8),
            new Card("K♥", 213, "🂾", "heart", "red", 13),
            new Card("6♠", 106, "🂦", "spade", "black", 6)
        ];

        $playerCards = [
            new Card("8♠", 108, "🂨", "spade", "black", 8),
            new Card("Q♥", 212, "🂽", "heart", "red", 12),
            new Card("9♠", 109, "🂩", "spade", "black", 9)
        ];

        $playerHand = new BlackjackCardHand($playerCards);
        $dealerHand = new BlackjackCardHand($dealerCards);


        $player = new BlackjackPlayer("Player 1", [$playerHand]);
        $dealer = new BlackjackDealer([$dealerHand]);

        $player->wagerChips(100);
        $dealer->wagerChips(100);

        $gameResult = new BlackjackGameResults($player, $dealer);
        $roundResult = $gameResult->decideBlackjackRoundResults();

        $this->assertStringContainsString('Round Results: Player 1: +0, Dealer: +0', $roundResult['round-results']);
        $this->assertEquals(1000, $player->getChipCount());
        $this->assertEquals(1000, $dealer->getChipCount());
    }





    /**
     * Construct GameResult-object and ascertains that the game-round results
     * are formatted correctly.
     */
    public function testDecideBlackjackRoundResultsFormatting(): void
    {
        $dealerCards = [
            new Card("8♣", 408, "🃘", "club", "black", 8),
            new Card("K♥", 213, "🂾", "heart", "red", 13)
        ];

        $playerCards = [
            new Card("8♠", 108, "🂨", "spade", "black", 8),
            new Card("Q♥", 212, "🂽", "heart", "red", 12)
        ];

        $playerHand = new BlackjackCardHand($playerCards);
        $dealerHand = new BlackjackCardHand($dealerCards);


        $player = new BlackjackPlayer("Player 1", [$playerHand]);
        $dealer = new BlackjackDealer([$dealerHand]);

        $player->wagerChips(100);
        $dealer->wagerChips(100);

        $gameResults = new BlackjackGameResults($player, $dealer);
        $roundResult = $gameResults->decideBlackjackRoundResults();

        $this->assertIsArray($roundResult);
        $this->assertArrayHasKey('round-results', $roundResult);
        $this->assertArrayHasKey('chip-count', $roundResult);
        $this->assertArrayHasKey('chip-count-json', $roundResult);
    }

}
