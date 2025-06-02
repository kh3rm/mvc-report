<?php

namespace App\Controller\CardController;

use App\Deck\DeckOfCards;
use App\Deck\DeckOfCards52;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CardControllerJsonDeck
 * @package App\Controller
 *
 * This controller handles the deck-json-routes.
 */
class CardControllerJsonDeck extends AbstractController
{
    /**
     * @Route("/api/deck", name="api/deck")
     *
     * @return Response
     */
    #[Route("/api/deck", name: "api/deck")]
    public function apiDeck(): Response
    {
        $deckOfCardsNew = new DeckOfCards();
        $deckOfCards52 = new DeckOfCards52();

        $data = [
            "Message" => "Please make sure to first check the pretty-print box to be able to see the cards in the deck in their unicode-representation.",
            "newDeckOfCardsUnicode" => $deckOfCardsNew->getCardsUnicode(),
            "deckOfCards52Unicode(No-Jokers)" => $deckOfCards52->getCardsUnicode()
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }
}
