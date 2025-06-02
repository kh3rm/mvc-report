<?php

namespace App\Controller\GameController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GameControllerDoc
 * @package App\Controller
 *
 * This controller handles the game-doc-route.
 */
class GameControllerDoc extends AbstractController
{
    /**
     * Game Doc route
     *
     * @Route("/game/doc", name="gamedoc")
     * @return Response Returns the rendered view of the game/doc.html.twig-template.
     */
    #[Route("/game/doc", name: "gamedoc")]
    public function gameDoc(): Response
    {
        return $this->render('game/doc.html.twig');
    }
}
