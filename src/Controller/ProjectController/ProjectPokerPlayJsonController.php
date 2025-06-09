<?php

namespace App\Controller\ProjectController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\PokerPatienceGS\PokerPatienceGrid;
use App\PokerPatienceGS\EvaluateHands;

/**
 * Class ProjectPokerPlayJsonController
 * @package App\Controller\ProjectController
 *
 * This controller handles the API-route for retrieving the current game state
 * of the Project Poker Patience game.
 */
class ProjectPokerPlayJsonController extends AbstractController
{
    /**
     * Retrieve the current game state grid and scores for the Project Poker Patience game.
     *
     * @Route("proj/api/gamestate", name="api_gamestate_proj", methods={"GET"})
     * @param SessionInterface $session The session interface from which to retrieve the
     * gameplay data
     * @return Response Returns a JSON response containing the current game state grid and scores
     */
    #[Route("proj/api/gamestate", name: "api_gamestate_proj", methods: ['GET'])]
    public function pokerPatienceGridJson(SessionInterface $session): Response
    {
        $gameplayGrid = $session->get('gameplay_grid') ?? (function () use ($session) {
            $pokerPatienceGS = new PokerPatienceGrid();
            $grid = $pokerPatienceGS->getGrid();
            $session->set('gameplay_grid', $grid);
            return $grid;
        })();

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
