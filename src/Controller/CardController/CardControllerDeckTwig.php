<?php

namespace App\Controller\CardController;

use App\Deck\DeckOfCards;
use App\Deck\DeckOfCards52;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CardControllerDeckTwig
 * @package App\Controller
 *
 * This controller handles the deck-twig-routes.
 */
class CardControllerDeckTwig extends AbstractController
{
    #[Route("/card/deck", name: "deckofcards")]
    /**
     * Displays a new deck of cards.
     *
     * @param SessionInterface $session The session interface
     * @return Response The rendered response
     */
    public function deckOfCards(SessionInterface $session): Response
    {
        $deckOfCards = new DeckOfCards();

        $session->set("deck_of_cards", $deckOfCards);

        $data = [
            "deckofcardsobj" => $deckOfCards,
            "deckofcardsu" => $deckOfCards->getCardsUnicode()
        ];

        return $this->render('/card/deck.html.twig', $data);
    }


    #[Route("/card/deck/shuffle", name: "deckofcardsshuffle")]
    /**
     * Shuffles the deck of cards and displays it.
     *
     * @param SessionInterface $session The session interface
     * @return Response The rendered response
     */
    public function deckOfCardsShuffle(SessionInterface $session): Response
    {
        $deckOfCardsShuffle = new DeckOfCards52();
        $deckOfCardsShuffle->shuffleDeckOfCards();
        $session->set("deck_drawn", $deckOfCardsShuffle);

        /*         $exampleCard = $deckOfCardsShuffle->drawCard(); */

        $data = [
            "deckofcardsobjshuffle" => $deckOfCardsShuffle,
            "deckofcardsu" => $deckOfCardsShuffle->getCardsUnicode()
/*             "backofcard" => $exampleCard->getBackOfCard() */
        ];

        return $this->render('/card/deck-shuffle.html.twig', $data);
    }

}
