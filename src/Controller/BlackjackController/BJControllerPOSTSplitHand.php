<?php

namespace App\Controller\BlackjackController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BJControllerPOSTSplitHand
 *
 * This controller handles the blackjack-game's player split hand-route.
 */
class BJControllerPOSTSplitHand extends AbstractController
{
    #[Route("/game/split-hand", name: "split-hand", methods: ['POST'])]
    /**
     * Handle player's request to split a hand.
     *
     * @param SessionInterface $session
     * @param Request $request
     * @return Response
     */
    public function splitHand(SessionInterface $session, Request $request): Response
    {
        $handIndex = $request->request->get('handIndex');

        $player = $session->get('player');
        $dealer = $session->get('dealer');
        $deckInUse = $session->get('deck_in_use');
        $player->splitHand($handIndex, $deckInUse);

        $player->wagerChips(100);
        $dealer->wagerChips(100);

        $splitsAfforded = $session->get('splits_afforded');

        $session->set('player', $player);
        $session->set('dealer', $dealer);
        $session->set('deck_in_use', $deckInUse);
        $session->set("splits_afforded", ($splitsAfforded - 1));

        return $this->redirectToRoute('blackjack_play');
    }
}
