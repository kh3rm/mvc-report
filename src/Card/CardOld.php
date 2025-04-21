<?php

namespace App\Card;

class CardOld
{
    protected $cardValue;
    protected $cardInt;
    protected $cardUnicode;

    public const BACKOFCARD = '🂠';

    public function __construct($cValue, $cInt, $cGraph)
    {
        $this->cardValue = $cValue;
        $this->cardInt = $cInt;
        $this->cardUnicode = $cGraph;
    }

    public function getValue(): ?int
    {
        return $this->cardValue;
    }

    public function getAsString(): string
    {
        return "{$this->cardValue}";
    }

    public function getCardAsInt(): string
    {
        return $this->cardInt;
    }

    public function getCardAsUnicode(): string
    {
        return "{$this->cardUnicode}";
    }

}