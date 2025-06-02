<?php

namespace App\Controller\GameController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class GameControllerJson
 * @package App\Controller
 *
 * This controller handles the game-json-route.
 */
class GameControllerJson extends AbstractController
{
    /**
     * Game Json-route
     *
     * @Route("/api/game", name="api/game")
     * @return Response Returns JSON-respone of current chip-count in game.
     */
    #[Route("/api/game", name: "api/game")]
    public function apiGame(SessionInterface $session): Response
    {

        $currentChipCountJson = $session->get("current_chip_count_json");


        $data = $currentChipCountJson
        ? ["currentChipCountBlackJack" => $currentChipCountJson]
        : ["message" => "Currently no registered blackjack-game in progress."];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;

    }

}
