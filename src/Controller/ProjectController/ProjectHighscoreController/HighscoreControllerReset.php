<?php

namespace App\Controller\ProjectController\ProjectHighscoreController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\HighscoreEntryRepository;

/**
 * Class HighscoreControllerReset
 * @package App\Controller
 *
 * This controller handles the highscore-reset-route.
 */
final class HighscoreControllerReset extends AbstractController
{
    /**
     * Library Reset Route
     *
     * @Route("/proj/highscore/reset", name="highscore_reset")
     * @return Response Resets highscore-table.
     */
    #[Route('/proj/highscore/reset', name: 'highscore_reset')]
    public function resetHighscore(
        HighscoreEntryRepository $HSSEntryRepository
    ): Response {
        $HSSEntryRepository->resetHs();


        return $this->redirectToRoute('proj_highscore');
    }
}
