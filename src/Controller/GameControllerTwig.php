<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\CardGraphic;
use App\Card\CardHand;
use App\Card\DeckOfCards;
use App\Card\DeckOfCards52;
use App\Card\Player;
use App\Card\BlackjackPlayer;
use App\Card\BlackjackDealer;
use App\Card\BlackjackCardHand;
use App\Card\BlackjackGameResults;
use App\Helper\Helper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameControllerTwig extends AbstractController
{
    #[Route("/game", name: "gamelp")]
    public function gameLandingPage(): Response
    {
        return $this->render('game/game.html.twig');
    }

    #[Route("/game/doc", name: "gamedoc")]
    public function gameDoc(): Response
    {
        return $this->render('game/doc.html.twig');
    }


    #[Route("/game/rules", name: "gamerules")]
    public function gameRules(): Response
    {
        return $this->render('game/rules.html.twig');
    }


    #[Route("/game/init", name: "game_init_get", methods: ['GET'])]
    public function gameInit(SessionInterface $session): Response
    {
        $resetSessionHelp = new Helper();
        $resetSessionHelp->clearBlackjackGameSession($session);
        return $this->render('game/init.html.twig');
    }

}
