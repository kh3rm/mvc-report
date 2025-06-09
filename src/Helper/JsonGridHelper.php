<?php

namespace App\Helper;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Deck\DeckOfCards52;
use App\Blackjack\BlackjackCardHand\BlackjackCardHand;
use App\Blackjack\BlackjackPlayer\BlackjackPlayer;
use App\Blackjack\BlackjackPlayer\BlackjackDealer;
use App\PokerPatienceGS\PokerPatienceGrid;

/**
 * BlackjackHelper-Class.
 */
class JsonGridHelper
{
    public function initiateEmptyGameJson(SessionInterface $session): JsonResponse
    {
        $grid = new PokerPatienceGrid();
        $gameplayGrid = $grid->getGrid();

        $session->set('gameplay_grid', $gameplayGrid);

        $data = [
            "gameStateGrid" =>  $gameplayGrid,
            "scores" => $grid->establishEmptyScores(),
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT);

        return $response;
    }


}
