<?php

namespace App\Controller\BlackjackController;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BJControllerPOSTDealerHitHand
 *
 * This controller handles the blackjack-game's dealer hit-route.
 */
class BJControllerPOSTDealerHitHand extends AbstractController
{
    #[Route("/game/dealer-hit", name: "dealer-hit", methods: ['POST'])]
    /**
     * Handle dealer's request to hit.
     *
     * @param SessionInterface $session
     * @return Response
     */
    public function dealerHit(SessionInterface $session): Response
    {
        $dealer = $session->get('dealer');
        $deckInUse = $session->get('deck_in_use');
        $dealer->getHands()[0]->drawCardFromDeck($deckInUse);

        $session->set('dealer', $dealer);
        $session->set('deck_in_use', $deckInUse);

        return $this->redirectToRoute('blackjack_play');
    }
}
