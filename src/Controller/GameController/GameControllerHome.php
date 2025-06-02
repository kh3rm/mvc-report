<?php

namespace App\Controller\GameController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GameControllerHome
 * @package App\Controller
 *
 * This controller handles the game-home-route.
 */
class GameControllerHome extends AbstractController
{
    /**
     * Game Landing Page-route
     *
     * @Route("/game", name="gamelp")
     * @return Response Returns the rendered view of the game/game.html.twig-template.
     */
    #[Route("/game", name: "gamelp")]
    public function gameLandingPage(): Response
    {
        return $this->render('game/game.html.twig');
    }
}
