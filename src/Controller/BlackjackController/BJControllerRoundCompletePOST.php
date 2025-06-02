<?php

namespace App\Controller\BlackjackController;

use App\Blackjack\BlackjackGameResults\BlackjackGameResults;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BJControllerRoundCompletePOST
 *
 * This controller handles the blackjack-game's round-complete post-route.
 */
class BJControllerRoundCompletePOST extends AbstractController
{
    #[Route("/game/round-complete", name: "round-complete", methods: ['POST'])]
    /**
     * Handles the completion of a round and processes the game results.
     */
    public function roundComplete(SessionInterface $session): Response
    {
        $player = $session->get('player');
        $dealer = $session->get('dealer');

        $blackjackGameResults = new BlackjackGameResults($player, $dealer);

        $gameResultArray = $blackjackGameResults->decideBlackjackRoundResults();
        $gameDecided = $blackjackGameResults->getGameDecided();

        $session->set('player', $player);
        $session->set('dealer', $dealer);
        $session->set('roundmsg', $gameResultArray['round-results']);
        $session->set('current_chip_count', $gameResultArray['chip-count']);
        $session->set('current_chip_count_json', $gameResultArray['chip-count-json']);
        $session->set('game_decided', $gameDecided);

        if ($gameDecided) {
            $session->set('game-finished-object', $blackjackGameResults);
        }

        return $this->redirectToRoute('round_finished');
    }
}
