<?php

namespace App\Card;

class Card
{
    protected $cardValue;
    protected $cardInt;
    protected $cardUnicode;
    protected $cardSuit;
    protected $cardRank;

    protected $cardColor;

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
}
