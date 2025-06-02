<?php

namespace App\Controller\BlackjackController;

use App\Helper\BlackjackHelper\BlackjackHelper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BJControllerRoundPOSTNRInit
 *
 * This controller handles the blackjack-game's next round init post-route.
 */
class BJControllerRoundPOSTNRInit extends AbstractController
{
    #[Route("/game/next-round-init", name: "next_round_init", methods: ['POST'])]
    /**
     * Initializes the next round and sets up the next hands for player and dealer.
     */
    public function nextRoundInit(
        Request $request,
        SessionInterface $session
    ): Response {
        $numberOfHands = (int)$request->request->get('number_of_hands', 1);

        $player = $session->get('player');
        $dealer = $session->get('dealer');

        $nextRound = new BlackjackHelper();
        $nextRound->nextRoundInitHelper($player, $dealer, $numberOfHands, $session);

        return $this->redirectToRoute('blackjack_play');
    }

}
