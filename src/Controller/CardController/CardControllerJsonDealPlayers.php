<?php

namespace App\Controller\CardController;

use App\Deck\DeckOfCards52;
use App\Player\Player;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CardControllerJsonDealPlayers
 * @package App\Controller
 *
 * This controller handles the deal-player-cards-json-route.
 */
class CardControllerJsonDealPlayers extends AbstractController
{
    /**
     * Deals cards to players.
     *
     * @param int $players Number of players.
     * @param int $cards Number of cards per player.
     * @return Response JSON response containing players and their cards.
     */
    #[Route("api/deck/deal/{players}/{cards}", name: "api/deck/deal/players/cards", methods: ['POST'])]
    public function apiDealPlayersCards(int $players, int $cards): Response
    {
        $dealPlayer52Shuffled = new DeckOfCards52();
        $dealPlayer52Shuffled->shuffleDeckOfCards();

        $cardsToDeal = $players * $cards;

        if ($cardsToDeal > 52) {
            return new JsonResponse([
                "error" => "There are only 52 cards in the deck, and your combination of players($players) X cards ($cards) exceeds it.
                In other words: there are not enough cards in the deck to supply the given number of cards to all the given number of players.
                Modify the number(s) submitted and try again."
            ], Response::HTTP_BAD_REQUEST);
        }

        $drawnCards =  $dealPlayer52Shuffled->drawCards($cardsToDeal);
        $playersArray = [];

        if ($drawnCards !== null) {
            for ($i = 0; $i < $players; $i++) {
                $playerCards = array_slice($drawnCards, $i * $cards, $cards);
                $playerNr = ($i + 1);
                $playersArray[] = new Player("Player $playerNr", $playerCards);
            }
        }

        $data = [
            "Message" => "Please make sure to first check the pretty-print box to be able to see the cards in their unicode-representation.",
            "players" => array_map(function ($player) {
                return $player->getNameAndHandUnicodeJson();
            }, $playersArray),
            "remainingNrOfCardsInDeck" => $dealPlayer52Shuffled->getNumberOfCardsLeft(),
            "remainingDeckUnicode" => $dealPlayer52Shuffled->getCardsUnicode()
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }
}
