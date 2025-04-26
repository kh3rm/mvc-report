<?php

namespace App\Card;

class Player
{
    protected string $playerName;
    protected CardHand $hand;

    public function __construct(string $playerName, array $cardsDealt)
    {
        $this->playerName = $playerName;
        $this->hand = new CardHand($cardsDealt);
    }

    public function getHand(): CardHand
    {
        return $this->hand;
    }

    public function getPlayerName(): string
    {
        return $this->playerName;
    }

    public function getCardsInHandAsString(): string
    {
        return $this->hand->getCardsAsString();
    }

    public function getCardsInHandAsUnicode(): string
    {
        return $this->hand->getCardsAsUnicode();
    }

    public function getNameAndHandUnicodeJson(): array
    {
        return [
            'playerName' => $this->playerName,
            'playerHandUnicode' => $this->hand->getCardsAsUnicode(),
        ];
    }
}
