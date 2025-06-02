<?php

namespace App\Card;

/**
 * Card-Class, for a regular playing card, or joker, found in a classical deck of cards.
 */
class Card
{
    protected string $cardValue;
    protected int $cardInt;
    protected string $cardUnicode;
    protected string $cardSuit;
    protected int $cardRank;

    protected string $cardColor;

    protected const BACKOFCARD = '🂠';

    /**
     * Constructor.
     *
     */
    public function __construct(string $cValue, int $cInt, string $cGraph, string $cSuit, string $cColor, int $cRank)
    {
        $this->cardValue = $cValue;
        $this->cardInt = $cInt;
        $this->cardUnicode = $cGraph;
        $this->cardSuit = $cSuit;
        $this->cardColor = $cColor;
        $this->cardRank = $cRank;
    }

    /**
     * Gets value of card.
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->cardValue;
    }

    /**
     * Gets rank of card.
     *
     * @return int
     */
    public function getRank(): int
    {
        return $this->cardRank;
    }

    /**
     * Gets suit of card.
     *
     * @return string
     */
    public function getSuit(): string
    {
        return $this->cardSuit;
    }

    /**
     * Gets color of card.
     *
     * @return string
     */
    public function getColor(): string
    {
        return $this->cardColor;
    }


    //  getAsString() is slightly superfluous at this juncture, as it mimics getValue(), but I intend to
    //  perhaps later implement a version that is able to instead return "Two of hearts" or the like.
    public function getAsString(): string
    {
        return "{$this->cardValue}";
    }

    /**
     * Gets card as int.
     *
     * @return int
     */
    public function getCardAsInt(): int
    {
        return $this->cardInt;
    }

    /**
     * Gets card as unicode.
     *
     * @return string
     */
    public function getCardAsUnicode(): string
    {
        return "{$this->cardUnicode}";
    }

    /**
     * Gets back of card.
     *
     * @return string
     */
    public static function getBackOfCard(): string
    {
        return self::BACKOFCARD;
    }

    /**
     * Returns bool, true/false, whether card is facecard or not.
     *
     * @return bool
     */
    public function isFaceCard(): bool
    {
        return in_array($this->cardRank, ['11', '12', '13']);
    }
}
