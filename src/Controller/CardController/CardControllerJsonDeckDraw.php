<?php

namespace App\Controller\CardController;

use App\Deck\DeckOfCards52;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CardControllerJsonDeckDraw
 * @package App\Controller
 *
 * This controller handles the draw-json-routes.
 */
class CardControllerJsonDeckDraw extends AbstractController
{
    #[Route("api/deck/draw", name: "api/deck/draw", methods: ['POST'])]
    /**
     * Draw a single card from the deck via API.
     */
    public function apiDrawCard(SessionInterface $session): Response
    {

        $deck52DrawShuffled = $session->has("api_shuffle_deck")
        ? $session->get("api_shuffle_deck")
        : (new DeckOfCards52())->shuffleDeckOfCards();

        /** @var DeckOfCards52 $deck52DrawShuffled */
        $drawnCard = $deck52DrawShuffled->drawCard();

        if ($drawnCard === null) {
            return new JsonResponse([
                "error" => 'No cards left to draw in the deck, you have drawn all 52. Either clear the session, or reshuffle the deck, to be able to draw cards again.'
            ], Response::HTTP_BAD_REQUEST);
        }

        $session->set("api_shuffle_deck", $deck52DrawShuffled);


        $data = [
            "Message" => "Please make sure to first check the pretty-print box to be able to see the cards in their unicode-representation.",
            "drawnCardThisTimeUnicode" => $drawnCard->getCardAsUnicode(),
            "drawnCardsOverall" => $deck52DrawShuffled->getCardsDrawnUnicode(),
            "remainingNrOfCardsInDeck" => $deck52DrawShuffled->getNumberOfCardsLeft(),
            "remainingDeckUnicode" => $deck52DrawShuffled->getCardsUnicode()
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;

    }
}
