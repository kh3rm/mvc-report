<?php

namespace App\Tests\BlackjackGameResults\TestModules;

use App\Blackjack\BlackjackPlayer\BlackjackPlayer;
use App\Blackjack\BlackjackPlayer\BlackjackDealer;
use App\Blackjack\BlackjackGameResults\BlackjackGameResults;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

trait BJGGRSessionTest
{
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
