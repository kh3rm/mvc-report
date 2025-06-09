<?php

namespace App\Controller\BlackjackController;

use App\Blackjack\BlackjackPlayer\BlackjackPlayer;
use App\Blackjack\BlackjackPlayer\BlackjackDealer;
use App\Helper\BlackjackHelper\BlackjackHelper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BJControllerRoundPOSTInit
 *
 * This controller handles the blackjack game's init post-route.
 */
class BJControllerRoundPOSTInit extends AbstractController
{
    #[Route("/game/init", name: "blackjack_init_post", methods: ['POST'])]
    /**
     * Initializes the game by establishing the player, dealer, and deck-objects in session.
     */
    public function initCallback(
        Request $request,
        SessionInterface $session
    ): Response {
        $playerName = trim((string) $request->request->get('player_name', ''));
        $startingChips = (int) $request->request->get('starting_chips');
        $numberOfHands = (int) $request->request->get('number_of_hands');

        if (empty($playerName)) {
            $this->addFlash('warning', 'Sorry, you need to provide a valid player name.');
            return $this->redirectToRoute('game_init_get');
        }

        if (($numberOfHands * 100) > $startingChips) {
            $this->addFlash('warning', 'Sorry, the number of hands can maximally be the starting chips / 100.');
            return $this->redirectToRoute('game_init_get');
        }

        $player = new BlackjackPlayer($playerName, [], (int)$startingChips);
        $dealer = new BlackjackDealer([], (int)$startingChips);

        $newBlackjackHelper = new BlackjackHelper();

        $newBlackjackHelper->nextRoundInitHelper($player, $dealer, $numberOfHands, $session);

        return $this->redirectToRoute('blackjack_play');
    }


}
