<?php

namespace App\Card;

class Card
{
    protected string $cardValue;
    protected int $cardInt;
    protected string $cardUnicode;
    protected string $cardSuit;
    protected int $cardRank;

    protected string $cardColor;

    protected const BACKOFCARD = '🂠';

    public function __construct(string $cValue, int $cInt, string $cGraph, string $cSuit, string $cColor, int $cRank)
    {
        $this->cardValue = $cValue;
        $this->cardInt = $cInt;
        $this->cardUnicode = $cGraph;
        $this->cardSuit = $cSuit;
        $this->cardColor = $cColor;
        $this->cardRank = $cRank;
    }

    public function getValue(): string
    {
        return $this->cardValue;
    }

    public function getRank(): int
    {
        return $this->cardRank;
    }

    public function getSuit(): string
    {
        return $this->cardSuit;
    }

    public function getColor(): string
    {
        return $this->cardColor;
    }


    //  getAsString() is slightly superfluous at this juncture, as it mimics getValue(), but I intend to
    //  perhaps later implement a version that is able to instead return "Two of hearts" or the like.
    public function getAsString(): string
    {
        return "{$this->cardValue} ";
    }

    public function getCardAsInt(): int
    {
        return $this->cardInt;
    }

    public function getCardAsUnicode(): string
    {
        return "{$this->cardUnicode}";
    }

    public static function getBackOfCard(): string
    {
        return self::BACKOFCARD;
    }

    public function isFaceCard(): bool
    {
        return in_array($this->cardRank, ['11', '12', '13']);
    }
}
