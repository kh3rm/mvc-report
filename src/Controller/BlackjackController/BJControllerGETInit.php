<?php

namespace App\Controller\BlackjackController;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Helper\BlackjackHelper\SessionHelper;

/**
 * Class BJControllerGETInit
 *
 * This controller handles the blackjack-game's init GET-route.
 */
class BJControllerGETInit extends AbstractController
{
    /**
     * Initiates game..
     *
     * @Route("/game/init", name="game_init_get")
     *
     * @return Response Returns the rendered view of the game/init.html.twig template.
     */
    #[Route("/game/init", name: "game_init_get", methods: ['GET'])]
    public function gameInit(SessionInterface $session): Response
    {
        $resetSessionHelp = new SessionHelper();
        $resetSessionHelp->clearBlackjackGameSession($session);
        return $this->render('game/init.html.twig');
    }
}
