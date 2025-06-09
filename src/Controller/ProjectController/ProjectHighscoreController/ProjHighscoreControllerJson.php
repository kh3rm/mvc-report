<?php

namespace App\Controller\ProjectController\ProjectHighscoreController;

use App\Repository\HighscoreEntryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Class ProjHighscoreControllerJson
 * @package App\Controller
 *
 * This controller handles the highscore-json-routes.
 */
final class ProjHighscoreControllerJson extends AbstractController
{
    private HighscoreEntryRepository $hsEntryRepository;

    public function __construct(HighscoreEntryRepository $hsEntryRepository)
    {
        $this->hsEntryRepository = $hsEntryRepository;
    }


    /**
     * Retrieve all high scores in JSON format
     * @Route("/api/proj/highscore", name="highscore_api_proj")
     * @return Response Returns a JSON response with all high scores.
     */
    #[Route('proj/api/highscore', name: 'highscore_api_proj')]
    public function showHighscoreApi(): Response
    {
        $highscoreEntries = $this->hsEntryRepository->findAllEntriesScoreDesc();

        $response = $this->json($highscoreEntries);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
