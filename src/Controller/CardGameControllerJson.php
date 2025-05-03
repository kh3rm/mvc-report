<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\CardGraphic;
use App\Card\CardHand;
use App\Card\DeckOfCards;
use App\Card\DeckOfCards52;
use App\Card\Player;
use JsonSerializable;
use PhpParser\JsonDecoder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CardGameControllerJson extends AbstractController
{
    #[Route("/api/deck", name: "api/deck")]
    public function apiDeck(): Response
    {

        $deckOfCardsNew = new DeckOfCards();
        $deckOfCards52 = new DeckOfCards52();

        $data = [
            "Message" => "Please make sure to first check the pretty-print box to be able to see the cards in the deck in their unicode-representation.",
            "newDeckOfCardsUnicode" => $deckOfCardsNew->getUnicodeCardsAsString(),
            "newDeckOfCardsSimple" => $deckOfCardsNew->getCardsAsString(),
            "deckOfCards52Unicode(No-Jokers)" => $deckOfCards52->getUnicodeCardsAsString(),
            "deckOfCards52Simple(No-Jokers)" => $deckOfCards52->getCardsAsString()
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;

    }


    #[Route("api/deck/shuffle", name: "api/deck/shuffle", methods: ['POST'])]
    public function apiDeckShuffle(SessionInterface $session): Response
    {

        $deck52Shuffled = new DeckOfCards52();
        $deck52Shuffled->shuffleDeckOfCards();

        $session->set("api_shuffle_deck", $deck52Shuffled);

        $testSort = clone $deck52Shuffled;

        $testSort2 = clone $testSort;

        $testSort2->sortDeckFirstByRankThenBySuit();

        $testSort->sortDeck();



        $data = [
            "Message" => "Please make sure to first check the pretty-print box to be able to see the cards in the deck in their unicode-representation.",
            "deckOfCards52UnicodeShuffled(No-Jokers)" => $deck52Shuffled->getUnicodeCardsAsString(),
            "deckOfCards52SimpleShuffled(No-Jokers)" => $deck52Shuffled->getCardsAsString(),
            "deckOfCards52UnicodeSortedAgainTest" => $testSort->getUnicodeCardsAsString(),
            "deckOfCards52UnicodeSortedAgainTestFirstRankThenSuit" => $testSort2->getUnicodeCardsAsString()
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;

    }

    #[Route("api/deck/draw", name: "api/deck/draw", methods: ['POST'])]
    public function apiDrawCard(SessionInterface $session): Response
    {

        $deck52DrawShuffled = $session->has("api_shuffle_deck")
        ? $session->get("api_shuffle_deck")
        : (new DeckOfCards52())->shuffleDeckOfCards();

        $drawnCard = $deck52DrawShuffled->drawCard();

        if ($drawnCard === null) {
            return new JsonResponse([
                "error" => 'No cards left to draw in the deck, you have drawn all 52. Either clear the session, or reshuffle the deck, to be able to draw cards again.'
            ], Response::HTTP_BAD_REQUEST);
        }

        $session->set("api_shuffle_deck", $deck52DrawShuffled);

        $drawnCardsOverall = $deck52DrawShuffled->getDrawnCards();

        $data = [
            "Message" => "Please make sure to first check the pretty-print box to be able to see the cards in their unicode-representation.",
            "drawnCardThisTimeUnicode" => $drawnCard->getCardAsUnicode(),
            "drawnCardsOverall" => $deck52DrawShuffled->getUnicodeStringOfDrawnCards($drawnCardsOverall),
            "remainingNrOfCardsInDeck" => $deck52DrawShuffled->getNumberOfCardsLeft(),
            "remainingDeckUnicode" => $deck52DrawShuffled->getUnicodeCardsAsString()
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;

    }



    #[Route("api/deck/draw/{number}", name: "api/deck/draw/number", methods: ['POST'])]
    public function apiDrawCards(SessionInterface $session, int $number): Response
    {

        $deck52DrawShuffled = $session->has("api_shuffle_deck")
        ? $session->get("api_shuffle_deck")
        : (new DeckOfCards52())->shuffleDeckOfCards();

        $cardsLeftInDeck = $deck52DrawShuffled->getNumberOfCardsLeft();


        if ($number > $cardsLeftInDeck) {
            return new JsonResponse([
                "error" => "The number of cards that you are trying to draw ($number) exceeds the number of cards left in the deck ($cardsLeftInDeck). Either revise your request, or try again after having cleared the session/resetting and reshuffling the deck."
            ], Response::HTTP_BAD_REQUEST);
        }


        $drawnCards = $deck52DrawShuffled->drawCards($number);

        $drawnCardsOverall = $deck52DrawShuffled->getDrawnCards();

        $session->set("api_shuffle_deck", $deck52DrawShuffled);

        $unicodeCardsDrawn = "";

        $unicodeCardsDrawn = $deck52DrawShuffled->getUnicodeStringOfDrawnCards($drawnCards);

        $data = [
            "Message" => "Please make sure to first check the pretty-print box to be able to see the cards in their unicode-representation.",
            "drawnCardsThisTimeUnicode" => $unicodeCardsDrawn,
            "drawnCardsOverall" => $deck52DrawShuffled->getUnicodeStringOfDrawnCards($drawnCardsOverall),
            "remainingNrOfCardsInDeck" => $deck52DrawShuffled->getNumberOfCardsLeft(),
            "remainingDeckUnicode" => $deck52DrawShuffled->getUnicodeCardsAsString()
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;

    }



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

        for ($i = 0; $i < $players; $i++) {
            $playerCards = array_slice($drawnCards, $i * $cards, $cards);
            $playerNr = ($i + 1);
            $playersArray[] = new Player("Player $playerNr", $playerCards);
        }

        $data = [
            "Message" => "Please make sure to first check the pretty-print box to be able to see the cards in their unicode-representation.",
            "players" => array_map(function ($player) {
                return $player->getNameAndHandUnicodeJson();
            }, $playersArray),
            "remainingNrOfCardsInDeck" => $dealPlayer52Shuffled->getNumberOfCardsLeft(),
            "remainingDeckUnicode" => $dealPlayer52Shuffled->getUnicodeCardsAsString()
        ];




        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;

    }
}
