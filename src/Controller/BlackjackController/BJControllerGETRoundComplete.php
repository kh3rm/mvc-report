<?php

namespace App\Controller\BlackjackController;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * BJControllerGETRoundComplete
 *
 * This controller handles the blackjack-round-complete route.
 */
class BJControllerGETRoundComplete extends AbstractController
{
    /**
     * Handles Blackjack-round completion.
     *
     * @Route("/game/round-complete", name="round_finished")
     *
     * @return Response Returns the rendered view of the game/round-results.html.twig template.
     */
    #[Route("/game/round-complete", name: "round_finished", methods: ['GET'])]
    public function roundFinished(
        SessionInterface $session
    ): Response {

        $player = $session->get("player");
        $dealer = $session->get("dealer");
        $gameResults = $session->get("game-finished-object");



        $data = [
            "player" => $player,
            "dealer" => $dealer,
            "deck" => $session->get('deck_in_use'),
            "roundmsg" => $session->get('roundmsg'),
            "chipcount" => $session->get('current_chip_count'),
            "game_decided" => $session->get('game_decided')
        ];

        if ($gameResults) {
            $gameResults->establishUpToDateSession($session);
            $gameResults->clearBlackjackGameSession();
        }

        return $this->render('game/round-results.html.twig', $data);
    }

}
