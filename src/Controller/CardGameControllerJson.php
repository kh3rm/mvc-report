<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\CardGraphic;
use App\Card\CardHand;
use App\Card\DeckOfCards;
use App\Card\DeckOfCards52;
use App\Card\Player;
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
            "Message" => "Please make sure to first check the pretty-print box to be able to see cards in the deck in their unicode-representation.",
            "newDeckOfCardsUnicode" => $deckOfCardsNew->getUnicodeCardsAsString(),
            "newDeckOfCardsSimple" => $deckOfCardsNew->getDeckAsString(),
            "deckOfCards52Unicode(No-Jokers)" => $deckOfCards52->getUnicodeCardsAsString(),
            "deckOfCards52Simple(No-Jokers)" => $deckOfCards52->getDeckAsString(),
            "newDeckOfCards-Object" => $deckOfCardsNew,
            "deckOfCards52-Object" => $deckOfCards52
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;

    }


    #[Route("api/deck/shuffle", name: "api/deck/shuffle", methods: ['GET'])]
    public function apiDeckShuffle(SessionInterface $session): Response
    {

        $deckOfCards52Shuffled = new DeckOfCards52();
        $deckOfCards52Shuffled->shuffleDeckOfCards();

        $session->set("api-shuffle-deck", $deckOfCards52Shuffled);



        $data = [
            "Message" => "Please make sure to first check the pretty-print box to be able to see cards in the deck in their unicode-representation.",
            "deckOfCards52UnicodeShuffled(No-Jokers)" => $deckOfCards52Shuffled->getUnicodeCardsAsString(),
            "deckOfCards52SimpleShuffled(No-Jokers)" => $deckOfCards52Shuffled->getDeckAsString(),
            "deckOfCards52Shuffled-Object" => $deckOfCards52Shuffled
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;

    }

    #[Route("api/deck/draw", name: "api/deck/draw", methods: ['GET'])]
    public function apiDrawCard(SessionInterface $session): Response
    {

        if ($session->has("api-shuffle-deck")) {
            $deckOfCardsDraw52Shuffled = $session->get("api-shuffle-deck");
        } else {
            $deckOfCardsDraw52Shuffled = new DeckOfCards52();
            $deckOfCardsDraw52Shuffled->shuffleDeckOfCards();
        }

        $drawnCard = $deckOfCardsDraw52Shuffled->drawCard();

        if ($drawnCard === null) {
            return new JsonResponse([
                "error" => 'No cards left to draw in the deck, you have drawn all 52. Either clear the session, or reshuffle the deck, to be able to draw cards again.'
            ], Response::HTTP_BAD_REQUEST);
        } else {

        $session->set("api-shuffle-deck", $deckOfCardsDraw52Shuffled);
        }

        $data = [
            "Message" => "Please make sure to first check the pretty-print box to be able to see cards in their unicode-representation.",
            "drawnCardUnicode" => $drawnCard->getCardAsUnicode(),
            "remainingNrOfCardsInDeck" => $deckOfCardsDraw52Shuffled->getNumberOfCardsLeft(),
            "remainingDeckUnicode"=> $deckOfCardsDraw52Shuffled->getUnicodeCardsAsString(),
            "remainingDeckObject"=> $deckOfCardsDraw52Shuffled
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;

    }



    #[Route("api/deck/draw/{number}", name: "api/deck/draw/number", methods: ['GET'])]
    public function apiDrawCards(SessionInterface $session, int $number): Response
    {

        if ($session->has("api-shuffle-deck")) {
            $deckOfCardsDraw52Shuffled = $session->get("api-shuffle-deck");
        } else {
            $deckOfCardsDraw52Shuffled = new DeckOfCards52();
            $deckOfCardsDraw52Shuffled->shuffleDeckOfCards();
        }

        $cardsLeftToDrawInDeck = $deckOfCardsDraw52Shuffled->getNumberOfCardsLeft();

        if ($number > $cardsLeftToDrawInDeck) {
            return new JsonResponse([
                "error" => "The number of cards that you are trying to draw ($number) supercedes the number of cards left in the deck ($cardsLeftToDrawInDeck). Either revise your request, or try again after having cleared the session/resetting and reshuffling the deck."
            ], Response::HTTP_BAD_REQUEST);
        } else {
            $drawnCards = $deckOfCardsDraw52Shuffled->drawCards($number);

            $session->set("api-shuffle-deck", $deckOfCardsDraw52Shuffled);
            }

            $unicodeCardsStringDrawnCards = "";

            $unicodeCardsStringDrawnCards = $deckOfCardsDraw52Shuffled->getUnicodeStringOfDrawnCards($drawnCards);

        $data = [
            "Message" => "Please make sure to first check the pretty-print box to be able to see cards in their unicode-representation.",
            "drawnCardsUnicode" => $unicodeCardsStringDrawnCards,
            "remainingNrOfCardsInDeck" => $deckOfCardsDraw52Shuffled->getNumberOfCardsLeft(),
            "remainingDeckUnicode"=> $deckOfCardsDraw52Shuffled->getUnicodeCardsAsString(),
            "remainingDeckObject"=> $deckOfCardsDraw52Shuffled
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;

    }



    #[Route("api/deck/deal/{players}/{cards}", name: "api/deck/deal/players/cards", methods: ['GET'])]
    public function apiDealPlayersCards(SessionInterface $session, int $players, int $cards): Response
    {


        $dealPlayersDeck52Shuffled = new DeckOfCards52();
        $dealPlayersDeck52Shuffled->shuffleDeckOfCards();

        $cardsToDeal = $players * $cards;


        if ($cardsToDeal > 52) {
            return new JsonResponse([
                "error" => "There are only 52 cards in the deck, and your combination of players($players) X cards ($cards) supercedes it.
                In other words: there are not enough cards in the deck to supply the given number of cards to all the given number of players.
                Modify the number(s) submitted and try again."
            ], Response::HTTP_BAD_REQUEST);
        }


        $drawnCards =  $dealPlayersDeck52Shuffled->drawCards($cardsToDeal);
        $playersArray = [];

        for ($i = 0; $i < $players; $i++) {
            $playerCards = array_slice($drawnCards, $i * $cards, $cards);
            $playerNr = ($i + 1);
            $playersArray[] = new Player("Player $playerNr",$playerCards);
        }

        $data = [
            "Message" => "Please make sure to first check the pretty-print box to be able to see cards in their unicode-representation.",
            "players" => array_map(function($player) {
                return $player->getNameAndHandUnicodeJson();
            }, $playersArray),
            "remainingNrOfCardsInDeck" =>  $dealPlayersDeck52Shuffled->getNumberOfCardsLeft(),
            "remainingDeckUnicode"=>  $dealPlayersDeck52Shuffled->getUnicodeCardsAsString()
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;

    }
}