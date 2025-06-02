<?php

namespace App\Controller\BlackjackController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BJControllerPOSTHitHand
 *
 * This controller handles the blackjack-game's player hit hand-route.
 */
class BJControllerPOSTHitHand extends AbstractController
{
    #[Route("/game/hit-hand", name: "game_hit", methods: ['POST'])]
    /**
     * Handle player's request to hit a hand.
     *
     * @param SessionInterface $session
     * @param Request $request
     * @return Response
     */
    public function hitHand(SessionInterface $session, Request $request): Response
    {
        $handIndex = $request->request->get('handIndex');

        $player = $session->get('player');
        $deckInUse = $session->get('deck_in_use');
        $cardToBeAdded = $deckInUse->drawCard();
        $player->addCardToHand($handIndex, $cardToBeAdded);

        $session->set('deck_in_use', $deckInUse);
        $session->set('player', $player);

        return $this->redirectToRoute('blackjack_play');
    }
}
