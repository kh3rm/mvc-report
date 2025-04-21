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

    public const BACKOFCARD = '🂠';

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
        return "{$this->cardValue}";
    }

    public function getCardAsInt(): int
    {
        return $this->cardInt;
    }

    public function getCardAsUnicode(): string
    {
        return "{$this->cardUnicode}";
    }


    public function toStyledString(): string
    {
        $class = $this->getColor() === 'red' ? 'red-card' : 'black-card';
        return "<span class='$class'>" . htmlspecialchars($this->getAsString()) . "</span>";
    }


    public function toStyledStringUnicode(): string
    {
        $class = $this->getColor() === 'red' ? 'red-card' : 'black-card';
        return "<span class='$class'>" . htmlspecialchars($this->getCardAsUnicode()) . "</span>";
    }


    public function getStyledString(bool $useUnicode = false): string
    {
        $class = $this->getColor() === 'red' ? 'red-card' : 'black-card';
        $content = $useUnicode ? htmlspecialchars($this->cardUnicode) : htmlspecialchars($this->cardValue);
        return "<span class='$class'>$content</span>";
    }
}
