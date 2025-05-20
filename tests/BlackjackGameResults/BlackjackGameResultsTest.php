<?php

namespace App\Card;

use App\Exception\NotEnoughChipsException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class BlackjackGameResultsTest extends TestCase
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



    /**
     * Construct GameResult-object and ascertains that the session is established
     * correctly with the given session interface and successfully updates the
     * session state, using mocking.
     */
    public function testEstablishSession(): void
    {
        $player = new BlackjackPlayer("Player 1", []);
        $dealer = new BlackjackDealer([]);
        $gameResults = new BlackjackGameResults($player, $dealer);


        $mockSession = $this->createMock(SessionInterface::class);

        $gameResults->establishUpToDateSession($mockSession);

        $this->assertInstanceOf(SessionInterface::class, $gameResults->getSessionState());
    }

    /**
     * Construct GameResult-object and ascertains that the session variables are cleared
     * correctly when the clearBlackjackGameSession() method is called after establishing
     * the session, using mocking.
     */
    public function testClearSession(): void
    {
        $player = new BlackjackPlayer("Player 1", []);
        $dealer = new BlackjackDealer([]);
        $gameResults = new BlackjackGameResults($player, $dealer);

        $mockSession = $this->createMock(SessionInterface::class);


        $sessionVariables = [
            ['deck_in_use'],
            ['player'],
            ['dealer'],
            ['splits_afforded'],
            ['roundmsg'],
            ['game_decided'],
            ['smallest_chip_count'],
            ['maximum_hands'],
            ['game-finished-object'],
            ['current_chip_count'],
            ['current_chip_count_json']
        ];

        $mockSession->expects($this->exactly(count($sessionVariables)))
            ->method('remove')
            ->withConsecutive(...$sessionVariables);

        $gameResults->establishUpToDateSession($mockSession);
        $gameResults->clearBlackjackGameSession();
    }

}
