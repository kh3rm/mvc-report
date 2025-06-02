<?php

namespace App\Controller\CardController;

use App\Deck\DeckOfCards52;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CardControllerJsonDeckShuffle
 * @package App\Controller
 *
 * This controller handles the deck-shuffle-json-routes.
 */
class CardControllerJsonDeckShuffle extends AbstractController
{
    /**
     * Shuffle the deck of cards and return the shuffled and sorted decks as JSON.
     *
     * @param SessionInterface $session
     * @return Response
     */
    #[Route("api/deck/shuffle", name: "api/deck/shuffle", methods: ['POST'])]
    public function apiDeckShuffle(SessionInterface $session): Response
    {
        $deck52Shuffled = new DeckOfCards52();
        $deck52Shuffled->shuffleDeckOfCards();

        $session->set("api_shuffle_deck", $deck52Shuffled);

        $testSort = clone $deck52Shuffled;

        $testSort2 = clone $testSort;

        $testSort->sortDeck();

        $testSort2->sortDeckFirstByRankThenBySuit();

        $data = [
            "Message" => "Please make sure to first check the pretty-print box to be able to see the cards in the deck in their unicode-representation.",
            "deckOfCards52UnicodeShuffled(No-Jokers)" => $deck52Shuffled->getCardsUnicode(),
            "deckOfCards52UnicodeSortedAgainTest" => $testSort->getCardsUnicode(),
            "deckOfCards52UnicodeSortedAgainTestFirstRankThenSuit" => $testSort2->getCardsUnicode()
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }
}
