<?php

namespace App\Controller\ProjectController\ProjectBlackjackController;

use App\Blackjack\BlackjackPlayer\BlackjackPlayer;
use App\Blackjack\BlackjackPlayer\BlackjackDealer;
use App\Helper\BlackjackHelper\BlackjackHelper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Helper\BlackjackHelper\SessionHelper;

/**
 * Class BJControllerRoundPOSTInit
 *
 * This controller handles the blackjack game's init post-route.
 */
class BJControllerProjectPOSTInit extends AbstractController
{
    #[Route("/project/blackjack/init", name: "blackjack_init_post_project", methods: ['POST'])]
    /**
     * Initializes the project-bj-game by establishing the player, cat, and deck-objects in session.
     */
    public function initCallback(
        Request $request,
        SessionInterface $session
    ): Response {

        $helper = new SessionHelper();
        $helper->clearBlackjackGameSession($session);

        $playerName = $session->get('player_name_challenge');

        $session->set("project_game", true);

        $startingChips = 500;
        $numberOfHands = 5;

        $player = new BlackjackPlayer($playerName, [], (int)$startingChips);
        $dealer = new BlackjackDealer([], (int)$startingChips, "Cat");

        BlackjackHelper::nextRoundInitHelper($player, $dealer, $numberOfHands, $session);

        return $this->redirectToRoute('blackjack_play');
    }


}
