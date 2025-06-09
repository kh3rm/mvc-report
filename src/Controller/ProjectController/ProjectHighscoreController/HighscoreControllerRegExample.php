<?php

namespace App\Controller\ProjectController\ProjectHighscoreController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\HighscoreEntry;

/**
 * Class HighscoreControllerRegister
 * @package App\Controller
 *
 * This controller handles the registering of another highscore-entry
 * through a regular post-request.
 */
final class HighscoreControllerRegExample extends AbstractController
{
    /**
     * Create highscore-entry-route
     * @Route("/proj/api/register_highscore_example", name="proj_register_highscore_example", methods={"POST"})
     * @param Request $request The request object
     * @param ManagerRegistry $doctrine The doctrine manager registry
     * @return Response Redirects to the highscore view after registering the entry.
     */
    #[Route('/proj/api/register_highscore_example', name: 'proj_register_highscore_example', methods: ['POST'])]
    public function registerHighscore(Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $name = (string)$request->request->get('name', '');
        $score = (int)$request->request->get('score', 0);

        $entry = new HighscoreEntry();
        $entry->setName($name);
        $entry->setScore($score);

        $entityManager->persist($entry);
        $entityManager->flush();

        $dateCreated = $entry->getCreatedAt();

        $createdAtFormatted = $dateCreated ? $dateCreated->format('Y-m-d H:i:s T') : null;

        return new JsonResponse([
            'id' => $entry->getId(),
            'name' => $entry->getName(),
            'score' => $entry->getScore(),
            'created_at' => $createdAtFormatted
        ], Response::HTTP_CREATED);
    }
}
