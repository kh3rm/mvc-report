<?php

namespace App\Player;

use App\Card\Card;
use App\CardHand\CardHand;

/**
 * Generic initial Player-class.
 */
class Player
{
    protected string $playerName;
    protected CardHand $hand;

    /**
     * Constructor that takes two arguments at instantiation: a string of the
     * $playerName, and an array of the cards dealt to the player, used to
     * instantitate a new CardHand-object for the $hand.
     *
     * @param string $playerName
     * @param Card[] $cardsDealt
     */
    public function __construct(string $playerName, array $cardsDealt)
    {
        $this->playerName = $playerName;
        $this->hand = new CardHand($cardsDealt);
    }

    /**
     * Getter that returns the CardHand
     *
     * @return CardHand
     */
    public function getHand(): CardHand
    {
        return $this->hand;
    }

    /**
    * Getter that returns the playerName.
    *
    * @return string
    */
    public function getPlayerName(): string
    {
        return $this->playerName;
    }

    /**
     * Getter that returns the cards in hand as string.
     *
     * @return string
     */
    public function getCardsInHandAsString(): string
    {
        return $this->hand->getCardsAsString();
    }


    /**
     * Getter that returns the cards in hand as Unicode.
     *
     * @return string
     */
    public function getCardsInHandAsUnicode(): string
    {
        return $this->hand->getCardsAsUnicode();
    }


    /**
     * Method that returns the name of the player and the cards in hand in Unicode-representation,
     * in an associative array, in JSON-friendly-formatting, primarily for JSON-routes.
     *
     *  @return array<string,string> An associative array where:
     *  - 'playerName' is the player's name (string)
     *  - 'playerHandUnicode' is the cards in hand as Unicode (string)
     */
    public function getNameAndHandUnicodeJson(): array
    {
        return [
            'playerName' => $this->playerName,
            'playerHandUnicode' => $this->hand->getCardsAsUnicode(),
        ];
    }
}
