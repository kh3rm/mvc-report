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
 * This controller handles the Dice-game-roll-route.
 */
class DiceGameControllerRoll extends AbstractController
{
    #[Route("/game/pig/roll", name: "pig_roll", methods: ['POST'])]
    /**
     * Roll the dice for the pig game.
     *
     * @param SessionInterface $session
     * @return Response
     */
    public function roll(
        SessionInterface $session
    ): Response {
        $hand = $session->get("pig_dicehand");
        $hand->roll();

        $roundTotal = $session->get("pig_round");
        $round = 0;
        $values = $hand->getValues();
        foreach ($values as $value) {
            if ($value === 1) {
                $round = 0;
                $roundTotal = 0;

                $this->addFlash(
                    'warning',
                    'You got a 1 and you lost the round points!'
                );

                break;
            }
            $round += $value;
        }

        $session->set("pig_round", $roundTotal + $round);

        return $this->redirectToRoute('pig_play');
    }

}
