<?php

namespace App\Controller\BlackjackController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BJControllerPOSTStandHand
 * @package App\Controller
 *
 * This controller handles the blackjack-game's player stand hand-route.
 */
class BJControllerPOSTStandHand extends AbstractController
{
    #[Route("/game/stand-hand", name: "stand-hand", methods: ['POST'])]
    /**
     * Handle player's request to stand with a hand.
     *
     * @param SessionInterface $session
     * @param Request $request
     * @return Response
     */
    public function standHand(SessionInterface $session, Request $request): Response
    {
        $handIndex = $request->request->get('handIndex');

        $player = $session->get('player');
        $player->standHand($handIndex);
        $session->set('player', $player);

        return $this->redirectToRoute('blackjack_play');
    }
}
