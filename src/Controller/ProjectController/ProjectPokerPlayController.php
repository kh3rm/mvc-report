<?php

namespace App\Controller\ProjectController;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Deck\DeckOfCards52;
/* use App\PokerPatienceGS\PokerPatienceGS; */
use App\Helper\JsonGridHelper;

/**
 * Class BlackjackGameControllerGET
 * @package App\Controller
 *
 * This controller handles the /about-twig-route.
 */
class ProjectPokerPlayController extends AbstractController
{
    /**
    * Project Poker Patience Gameplay-route
    *
    * @Route("proj/poker-patience-play", name="")
    * @return Response Returns the rendered view of the api.twig-template.
    */
    #[Route("proj/poker-patience-play", name: "proj_poker_patience_play")]
    public function pokerPatiencePlayProj(Request $request, SessionInterface $session): Response
    {
        $playerName = $request->request->get('player_name');
        $session->set('player_name_challenge', $playerName);


        $jsonGridHelper = new JsonGridHelper();
        $jsonGridHelper->initiateEmptyGameJson($session);


        $deckInUse = new DeckOfCards52();
        $deckInUse->shuffleDeckOfCards();
        $drawn25Cards = $deckInUse->drawCards(25);
 /*        $pokerPatienceGS = new PokerPatienceGS(); */


        $catScore = 1;

        $data = [
            "drawncards" => $drawn25Cards,
            "placeholder"=> "🃴",
/*             "pokerPatienceGS" => $pokerPatienceGS, */
            "player_name" => $playerName,
            "player_current_score" => 0,
            "cat_score" =>$catScore
        ];

        return $this->render('project/poker-patience-play.html.twig', $data);
    }

}
