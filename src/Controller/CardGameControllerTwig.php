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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CardGameControllerTwig extends AbstractController
{
    #[Route("/card", name: "cardlp")]
    public function cardLandingPage(): Response
    {
        return $this->render('card.html.twig');
    }

    #[Route("/card/deck/draw", name: "carddraw")]
    public function cardDraw(SessionInterface $session): Response
    {
        $updatedDeckOfCards = $session->get("deck_drawn") ?? new DeckOfCards52();

        $drawnCard = $updatedDeckOfCards->drawCard();

        if ($drawnCard === null) {
            $this->addFlash(
                'warning',
                'No cards left to draw in the deck, you have drawn all 52. Either clear the session, or reshuffle the deck, to be able to draw cards again.'
            );
        }

        $session->set("deck_drawn", $updatedDeckOfCards);

        $data = [
            "drawncard" => $drawnCard,
            "updateddeck" => $updatedDeckOfCards
        ];

        return $this->render('card/draw.html.twig', $data);
    }



    #[Route("/card/deck/draw/{number}", name: "cardsdraw")]
    public function cardsDraw(SessionInterface $session, int $number): Response
    {

        $updatedDeckOfCards = $session->get("deck_drawn") ?? new DeckOfCards52();

        $drawnCards = $updatedDeckOfCards->drawCards($number);

        if ($drawnCards === null) {
            $this->addFlash(
                'warning',
                'You are trying to draw an amount of cards that is not valid in relation to the current deck.
                Either modify the number submitted, or try clearing the session/reshuffling the deck, to be able to draw the requested number of cards.'
            );
        }

        $session->set("deck_drawn", $updatedDeckOfCards);

        $data = [
            "drawncards" => $drawnCards,
            "updateddeck" => $updatedDeckOfCards
        ];

        return $this->render('card/draw-cards.html.twig', $data);
    }




    #[Route("/card/deck", name: "deckofcards")]
    public function deckOfCards(SessionInterface $session): Response
    {
        $deckOfCards = new DeckOfCards();
        $exampleCard = $deckOfCards->drawCard();

        $session->set("deck_of_cards", $deckOfCards);

        $data = [
            "deckofcardsobj" => $deckOfCards,
            "deckofcardsu" => $deckOfCards->getUnicodeCardsAsString(),
            "backofcard" => $exampleCard->getBackOfCard()
        ];

        return $this->render('/card/deck.html.twig', $data);
    }


    #[Route("/card/deck/shuffle", name: "deckofcardsshuffle")]
    public function deckOfCardsShuffle(SessionInterface $session): Response
    {
        $deckOfCardsShuffle = new DeckOfCards52();
        $deckOfCardsShuffle->shuffleDeckOfCards();
        $session->set("deck_drawn", $deckOfCardsShuffle);

        $exampleCard = $deckOfCardsShuffle->drawCard();

        $data = [
            "deckofcardsobjshuffle" => $deckOfCardsShuffle,
            "deckofcardsu" => $deckOfCardsShuffle->getUnicodeCardsAsString(),
            "backofcard" => $exampleCard->getBackOfCard()
        ];

        return $this->render('/card/deck-shuffle.html.twig', $data);
    }



    #[Route("card/deck/deal/{players}/{cards}", name: "dealplayers")]
    public function dealPlayers(SessionInterface $session, int $players, int $cards): Response
    {

        /* if ($session->has("deal-players-deck")) {
            $dealPlayersDeck = $session->get("deal-players-deck");
        } else {
            $dealPlayersDeck = new DeckOfCards52();
            $dealPlayersDeck->shuffleDeckOfCards();
        } */


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

        for ($i = 0; $i < $players; $i++) {
            $playerCards = array_slice($drawnCards, $i * $cards, $cards);
            $playerNr = ($i + 1);
            $playersArray[] = new Player("Player $playerNr", $playerCards);
        }

        $session->set("deal_players_deck", $dealPlayersDeck);



        $data = [
            "players" => $playersArray,
            "remainingdeck" => $dealPlayersDeck
        ];

        return $this->render('card/deal-player-cards.html.twig', $data);
    }

}
