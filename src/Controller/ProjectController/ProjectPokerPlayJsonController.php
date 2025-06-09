<?php

namespace App\Controller\ProjectController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\PokerPatienceGS\PokerPatienceGrid;
use App\PokerPatienceGS\EvaluateHands;

class ProjectPokerPlayJsonController extends AbstractController
{
    #[Route("proj/api/gamestate", name: "api_gamestate_proj", methods: ['GET'])]
    public function pokerPatienceGridJson(SessionInterface $session): Response
    {
        if ($session->has('gameplay_grid')) {
            $gameplayGrid = $session->get('gameplay_grid');
        } else {
            $pokerPatienceGS = new PokerPatienceGrid();
            $gameplayGrid = $pokerPatienceGS->getGrid();
            $session->set('gameplay_grid', $gameplayGrid);
        }

        $evaluateHands = new EvaluateHands($gameplayGrid);

        $scores = $evaluateHands->evaluate();

        $data = [
            "gameStateGrid" => $gameplayGrid,
            "scores" => $scores
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }
}
