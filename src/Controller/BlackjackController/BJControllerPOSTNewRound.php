<?php

namespace App\Controller\BlackjackController;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BJControllerPOSTNewRound
 *
 * This controller handles the blackjack-game's round/game-related post-routes.
 */
class BJControllerPOSTNewRound extends AbstractController
{
    #[Route("/game/next-round", name: "next-round", methods: ['POST'])]
    /**
     * Prepares for the next round based on current game state.
     */
    public function nextRound(SessionInterface $session): Response
    {
        $player = $session->get('player');
        $dealer = $session->get('dealer');
        $deckInUse = $session->get('deck_in_use');

        $gameDecided = $session->get('game_decided');

        $playerChipCount = $player->getChipCount();
        $dealerChipCount = $dealer->getChipCount();

        $smallestChipCount = min($playerChipCount, $dealerChipCount);

        $session->set('smallest_chip_count', $smallestChipCount);

        $maximumHands = $smallestChipCount / 100;
        $session->set('maximum_hands', $maximumHands);

        $data = [
            "player" => $player,
            "dealer" => $dealer,
            "deck" => $deckInUse,
            "maximum_hands" => $maximumHands,
            "game_decided" => $gameDecided
        ];

        return $this->render($session->has('project_game') ? 'game/project-next-round-init.html.twig' : 'game/next-round-init.html.twig', $data);
    }

}
