<?php

namespace App\Card;

class Player
{

    protected string $playerName = "";
    protected array $cardsInHand = [];
    protected array $cardsDiscarded = [];


    public function __construct(string $playerName,array $cardsDealt)
    {
        $this->playerName = $playerName;

        foreach ($cardsDealt as $card) {
            if (!$card instanceof Card) {
                throw new \Exception('All of the supplied elements of the $cardsDealt-array must be instances of a Card-object.');
            }
        }

        $this->cardsInHand = $cardsDealt;
    }

    public function getCardsInHand(): array
    {
        return $this->cardsInHand;
    }

    public function getPlayerName(): string
    {
        return $this->playerName;
    }

    public function addCardToHand(Card $card): void
    {
        $this->cardsInHand[] = $card;
    }

    public function getCardsInHandAsString(): string
    {
        $cardsString = [];
        foreach ($this->cardsInHand as $card) {
            $cardsString[] = $card->getAsString();
        }
        return implode(", ", $cardsString);
    }


    public function getCardsInHandAsUnicode(): string
    {
        $cardsUnicode = [];
        foreach ($this->cardsInHand as $card) {
            $cardsUnicode[] = $card->getCardAsUnicode();
        }
        return implode("", $cardsUnicode);
    }

    public function getNameAndHandUnicodeJson(): array
{

    $playerData = [
        'playerName' => $this->playerName,
        'playerHandUnicode' => $this->getCardsInHandAsUnicode(),
    ];


    return $playerData;
}
}