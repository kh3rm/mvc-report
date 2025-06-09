<?php

namespace App\Controller\ProjectController\ProjectHighscoreController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\HighscoreEntryRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class BlackjackGameControllerGET
 * @package App\Controller
 *
 * This controller handles the /about-twig-route.
 */
class ProjectHighscoreControllerTwig extends AbstractController
{
    /**
    * Project About-route
    *
    * @Route("proj/highscore", name="highscore")
    * @return Response Returns the rendered view of the api.twig-template.
    */
    #[Route("proj/highscore", name: "proj_highscore")]
    public function highscoreProj(HighscoreEntryRepository $hsEntryRepositoryRepository): Response
    {
        $highscoreTable = $hsEntryRepositoryRepository->findAllEntriesScoreDesc();

        $data = [
            "highscoretable" => $highscoreTable
        ];
        return $this->render('project/highscore.html.twig', $data);
    }

}
