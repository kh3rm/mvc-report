<?php

namespace App\Controller\CardController;

use App\Deck\DeckOfCards52;
use App\Player\Player;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CardControllerDealPlayersTwig
 * @package App\Controller
 *
 * This controller handles the deal-players-cards-twig-route.
 */
class CardControllerDealPlayersTwig extends AbstractController
{
    /**
     * Deals cards to a specified number of players.
     *
     * @param SessionInterface $session The session interface.
     * @param int $players The number of players.
     * @param int $cards The number of cards per player.
     * @return Response The rendered response for the dealt cards.
     */
    #[Route("card/deck/deal/{players}/{cards}", name: "dealplayers")]
    public function dealPlayers(SessionInterface $session, int $players, int $cards): Response
    {

        $dealPlayersDeck = new DeckOfCards52();
        $dealPlayersDeck->shuffleDeckOfCards();

        $cardsToDeal = $players * $cards;

        if ($cardsToDeal > 52) {
            $this->addFlash(
                'warning',
                'There are only 52 cards in the deck, and your combination of players X cards exceeds it.
                In other words: there are not enough cards in the deck to supply the given number of cards to all the given number of players.
                Modify the number(s) submitted and try again.'
            );
        }

        $drawnCards = $dealPlayersDeck->drawCards($cardsToDeal);
        $playersArray = [];

        if ($drawnCards !== null) {
            for ($i = 0; $i < $players; $i++) {
                $playerCards = array_slice($drawnCards, $i * $cards, $cards);
                $playerNr = ($i + 1);
                $playersArray[] = new Player("Player $playerNr", $playerCards);
            }
        }

        $session->set("deal_players_deck", $dealPlayersDeck);

        $data = [
            "players" => $playersArray,
            "remainingdeck" => $dealPlayersDeck
        ];

        return $this->render('card/deal-player-cards.html.twig', $data);
    }

}
