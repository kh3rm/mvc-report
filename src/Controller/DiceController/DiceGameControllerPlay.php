<?php

namespace App\Controller\DiceController;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DiceGameControllerPlay
 * @package App\Controller
 *
 * This controller handles Dice-game-play-route.
 */
class DiceGameControllerPlay extends AbstractController
{
    #[Route("/game/pig/play", name: "pig_play", methods: ['GET'])]
    /**
     * Play a round of the pig dice game.
     *
     * @param SessionInterface $session
     * @return Response
     */
    public function play(
        SessionInterface $session
    ): Response {
        $dicehand = $session->get("pig_dicehand");

        $data = [
            "pigDices" => $session->get("pig_dices"),
            "pigRound" => $session->get("pig_round"),
            "pigTotal" => $session->get("pig_total"),
            "diceValues" => $dicehand->getString()
        ];

        return $this->render('pig/play.html.twig', $data);
    }

}
