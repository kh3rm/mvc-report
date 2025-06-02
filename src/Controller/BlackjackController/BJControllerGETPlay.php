<?php

namespace App\Controller\BlackjackController;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * BJControllerGETPlay
 *
 * This controller handles the blackjack-gameplay route.
 */
class BJControllerGETPlay extends AbstractController
{
    /**
     * Gameplay-route.
     *
     * @Route("/game/play", name="blackjack_play")
     *
     * @return Response Returns the rendered view of the game/play.html.twig template.
     */
    #[Route("/game/play", name: "blackjack_play", methods: ['GET'])]
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
            "splits_afforded" => $session->get("splits_afforded")
        ];

        return $this->render('game/play.html.twig', $data);
    }
}
