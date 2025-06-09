<?php

namespace App\Controller\ProjectController\ProjectBlackjackController;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * BJControllerGETPlay
 *
 * This controller handles the blackjack-gameplay route.
 */
class ProjectBJControllerGETPlay extends AbstractController
{
    /**
     * Blackjack Project Gameplay-route.
     *
     * @Route("proj/blackjac/play", name="proj/blackjac/play")
     *
     * @return Response Returns the rendered view of the game/play.html.twig template.
     */
    #[Route("proj/blackjack/play", name: "blackjack_play_project", methods: ['GET'])]
    public function play(
        SessionInterface $session
    ): Response {

        $player = $session->get("player");
        $player->updateHandsStatus();
        $player->activeTurnStatus();

        $dealer = $session->get("dealer");

        if (!$player->isActiveTurn()) {
            $dealer->activateTurn();
        }


        $session->set("player", $player);
        $session->set("dealer", $dealer);


        $data = [
            "player" => $player,
            "dealer" => $dealer,
            "deck" => $session->get("deck_in_use"),
            "splits_afforded" => $session->get("splits_afforded"),
            "project_game"=> true
        ];

        return $this->render('game/play.html.twig', $data);
    }
}
