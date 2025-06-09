<?php

namespace App\Controller\ProjectController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\PokerPatienceGS\PokerPatienceGrid;
use App\PokerPatienceGS\EvaluateHands;
use App\Helper\JsonGridHelper;

/**
 * Class ProjectPokerPlayJsonUpdate
 * @package App\Controller\ProjectController
 *
 * This controller handles the API-route for updating the game state of
 * the Project Poker Patience game.
 */
class ProjectPokerPlayJsonUpdate extends AbstractController
{
    /**
     * Update the game state by adding a card to the grid, and returning dynamic results
     * for the gameplay-view.
     *
     * @Route("proj/api/updategamestate", name="api_update_gamestate_proj", methods={"POST"})
     * @param Request $request The HTTP request object containing the card and index data
     * @param SessionInterface $session The session interface in which to store the gameplay data
     * @return JsonResponse Returns a JSON response containing the updated game state
     * grid and scores, or an error message.
     */
    #[Route("proj/api/updategamestate", name: "api_update_gamestate_proj", methods: ['POST'])]
    public function updateGameState(Request $request, SessionInterface $session): JsonResponse
    {
        $gameplayGrid = [];
        $pokerPatienceGS = new PokerPatienceGrid();

        $gameplayGrid = $session->get('gameplay_grid') ?? (function () use ($session): array {
            $jsonGridHelper = new JsonGridHelper();
            $jsonGridHelper->initiateEmptyGameJson($session);

            return [];
        })();

        $pokerPatienceGS->setGrid($gameplayGrid);

        $content = json_decode($request->getContent(), true);

        $index = (int)$content['index'];
        $cardInt = (int)$content['card'];

        if ($pokerPatienceGS->addCardToGrid($cardInt, $index)) {
            $session->set('gameplay_grid', $pokerPatienceGS->getGrid());

            $evaluateHands = new EvaluateHands($pokerPatienceGS->getGrid());
            $scores = $evaluateHands->evaluate();

            return new JsonResponse([
                'success' => true,
                'gameStateGrid' => $pokerPatienceGS->getGrid(),
                'scores' => $scores
            ], Response::HTTP_OK);
        }

        return new JsonResponse(['error' => 'Failed to add card. '], Response::HTTP_BAD_REQUEST);
    }
}
