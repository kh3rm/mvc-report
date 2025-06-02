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
 * This controller handles the Dice-game-save-route.
 */
class DiceGameControllerSave extends AbstractController
{
    #[Route("/game/pig/save", name: "pig_save", methods: ['POST'])]
    /**
     * Save the current round points to the total.
     *
     * @param SessionInterface $session
     * @return Response
     */
    public function save(
        SessionInterface $session
    ): Response {
        $roundTotal = $session->get("pig_round");
        $gameTotal = $session->get("pig_total");

        $this->addFlash(
            'notice',
            'Your round was saved to the total!'
        );

        $session->set("pig_round", 0);
        $session->set("pig_total", $roundTotal + $gameTotal);

        return $this->redirectToRoute('pig_play');
    }
}
