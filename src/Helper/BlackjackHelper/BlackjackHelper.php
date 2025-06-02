<?php

namespace App\Helper\BlackjackHelper;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Deck\DeckOfCards52;
use App\Blackjack\BlackjackCardHand\BlackjackCardHand;
use App\Blackjack\BlackjackPlayer\BlackjackPlayer;
use App\Blackjack\BlackjackPlayer\BlackjackDealer;

/**
 * BlackjackHelper-Class.
 */
class BlackjackHelper
{
    use RoundWagerTrait;
    /**
     * nextRoundInitHelper()-method that contains the necessary logic to
     * initiate a new round of blackjack.
     */
    public static function nextRoundInitHelper(
        BlackjackPlayer $player,
        BlackjackDealer $dealer,
        int $numberOfHands,
        SessionInterface $session
    ): void {
        $deckInUse = new DeckOfCards52();
        $deckInUse->shuffleDeckOfCards();

        self::initializeHands($deckInUse, $player, $dealer, $numberOfHands);

        self::prepareExecuteWagering($player, $dealer, $numberOfHands, $session);

        $session->set("deck_in_use", $deckInUse);
        $session->set("player", $player);
        $session->set("dealer", $dealer);
    }

    /**
     * initializeHands()-method to handle the logic for creating player and dealer hands.
     */
    private static function initializeHands(DeckOfCards52 $deckInUse, BlackjackPlayer $player, BlackjackDealer $dealer, int $numberOfHands): void
    {
        $playerHands = [];
        for ($i = 0; $i < $numberOfHands; $i++) {
            $cards = $deckInUse->drawCards(2) ?? [];
            $playerHands[] = new BlackjackCardHand($cards);
        }

        $dealerCards = $deckInUse->drawCards(2) ?? [];
        $dealerHand = new BlackjackCardHand($dealerCards);

        $player->addHands(...$playerHands);
        $dealer->addHands($dealerHand);
    }
}
