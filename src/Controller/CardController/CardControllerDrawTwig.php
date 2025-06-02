<?php

namespace App\Controller\CardController;

use App\Deck\DeckOfCards52;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CardControllerDrawTwig
 * @package App\Controller
 *
 * This controller handles the deck-draw-routes.
 */
class CardControllerDrawTwig extends AbstractController
{
    /**
     * Draws a single card from the deck.
     *
     * @param SessionInterface $session The session interface.
     * @return Response The rendered response.
     */
    #[Route("/card/deck/draw", name: "carddraw")]
    public function cardDraw(SessionInterface $session): Response
    {
        $updatedDeckOfCards = $session->get("deck_drawn") ?? new DeckOfCards52();

        /** @var DeckOfCards52 $updatedDeckOfCards */
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

    /**
     * Draws a specified number of cards from the deck.
     *
     * @param SessionInterface $session The session interface.
     * @param int $number The number of cards to draw.
     * @return Response The rendered response.
     */
    #[Route("/card/deck/draw/{number}", name: "cardsdraw")]
    public function cardsDraw(SessionInterface $session, int $number): Response
    {

        $updatedDeckOfCards = $session->get("deck_drawn") ?? new DeckOfCards52();

        /** @var DeckOfCards52 $updatedDeckOfCards */
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

}
