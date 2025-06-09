<?php

namespace App\Controller\ProjectController\ProjectHighscoreController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\HighscoreEntry;

/**
 * Class HighscoreControllerRegister
 * @package App\Controller
 *
 * This controller handles the registering of another highscore-entry.
 */
final class HighscoreControllerRegister extends AbstractController
{

    /**
     * Create highscore-entry-route
     * @Route("/proj/api/register_highscore", name="book_create", methods={"POST"})
     * @param Request $request The request object
     * @param ManagerRegistry $doctrine The doctrine manager registry
     * @return Response Redirects to the highscore view after registering the entry.
     */
    #[Route('/proj/api/register_highscore', name: 'proj_register_highscore', methods: ['POST'])]
    public function registerHighscore(Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $data = json_decode($request->getContent(), true);

        $name = $data['playername'] ?? '';
        $score = $data['playerscore'] ?? 0;

        $entry = new HighscoreEntry();
        $entry->setName($name);
        $entry->setScore($score);
        $entityManager->persist($entry);
        $entityManager->flush();

        return $this->redirectToRoute('proj_highscore');
    }
}
