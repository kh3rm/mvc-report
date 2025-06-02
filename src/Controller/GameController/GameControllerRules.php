<?php

namespace App\Controller\GameController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GameControllerRules
 * @package App\Controller
 *
 * This controller handles the game-rules-route.
 */
class GameControllerRules extends AbstractController
{
    /**
     * Game Rules-route
     *
     * @Route("/game/rules", name="gamerules")
     * @return Response Returns the rendered view of the game/rules.html.twig.
     */
    #[Route("/game/rules", name: "gamerules")]
    public function gameRules(): Response
    {
        return $this->render('game/rules.html.twig');
    }
}
