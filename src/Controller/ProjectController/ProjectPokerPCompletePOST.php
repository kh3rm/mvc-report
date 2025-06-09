<?php

namespace App\Controller\ProjectController;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class rojectPokerPCompletePOST
 *
 * This controller handles the poker-patience-game's round-complete post-route.
 */
class ProjectPokerPCompletePOST extends AbstractController
{
    #[Route("proj/poker-patience-complete", name: "pokerp_complete_project", methods: ['POST'])]
    /**
     * Handles the completion of the poker patience and processes the results.
     */
    public function pokerPRoundCompletePOST(SessionInterface $session, Request $request): Response
    {
        $playerScore = $request->request->get('player_score');
        $catScore = $request->request->get('cat_score');

        $playerName = $session->get('player_name_challenge');

        $playerWon= true;


        if ($playerScore <= $catScore) {
            $playerWon = false;
        };

        $data = [
            "catscore"=> $catScore,
            "playername" => $playerName,
            "playerscore"=> $playerScore,
            "playerWon" => $playerWon
        ];


        return $this->render('/project/poker-patience-rcomplete.html.twig', $data);
    }
}
