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
class CardControllerJsonDeckDrawN extends AbstractController
{
    #[Route("api/deck/draw/{number}", name: "api/deck/draw/number", methods: ['POST'])]
    /**
     * Draw multiple cards from the deck via API.
     *
     * @param int $number Number of cards to draw.
     */
    public function apiDrawCards(SessionInterface $session, int $number): Response
    {

        $deck52DrawShuffled = $session->has("api_shuffle_deck")
        ? $session->get("api_shuffle_deck")
        : (new DeckOfCards52())->shuffleDeckOfCards();

        /** @var DeckOfCards52 $deck52DrawShuffled */
        $cardsLeftInDeck = $deck52DrawShuffled->getNumberOfCardsLeft();


        if ($number > $cardsLeftInDeck) {
            return new JsonResponse([
                "error" => "The number of cards that you are trying to draw ($number) exceeds the number of cards left in the deck ($cardsLeftInDeck). Either revise your request, or try again after having cleared the session/resetting and reshuffling the deck."
            ], Response::HTTP_BAD_REQUEST);
        }


        $drawnCards = $deck52DrawShuffled->drawCards($number);

        $session->set("api_shuffle_deck", $deck52DrawShuffled);

        $unicodeRoundDrawn = $drawnCards !== null ? $deck52DrawShuffled->getUnicodeOfRoundCards($drawnCards) : null;

        $data = [
            "Message" => "Please make sure to first check the pretty-print box to be able to see the cards in their unicode-representation.",
            "drawnCardsThisTimeUnicode" => $unicodeRoundDrawn,
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
