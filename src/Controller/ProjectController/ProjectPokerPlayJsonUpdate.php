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

class ProjectPokerPlayJsonUpdate extends AbstractController
{
    #[Route("proj/api/updategamestate", name: "api_update_gamestate_proj", methods: ['POST'])]
    public function updateGameState(Request $request, SessionInterface $session): JsonResponse
    {
        $pokerPatienceGS = new PokerPatienceGrid();


        if (!$session->has('gameplay_grid')) {
            $jsonGridHelper = new JsonGridHelper();
            $jsonGridHelper->initiateEmptyGameJson($session);
        } else {
            $gameplayGrid = $session->get('gameplay_grid');
        }

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
