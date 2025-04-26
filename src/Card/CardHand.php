<?php

namespace App\Card;

class CardHand
{
    protected array $cards = [];

    protected array $cardsDiscarded = [];

    public function __construct(array $cardsDealt = [])
    {
        $this->addCards($cardsDealt);
    }

    public function addCards(array $addedCards): void
    {
        foreach ($addedCards as $card) {
            if (!$card instanceof Card) {
                throw new \Exception('Sorry, you can only add instances of Card to the CardHand.');
            }
            $this->cards[] = $card;
        }
    }

    public function addCard(Card $card): void
    {
        $this->cards[] = $card;
    }



    public function getCards(): array
    {
        return $this->cards;
    }

    public function getCardsDiscarded(): array
    {
        return $this->cardsDiscarded;
    }

    public function getCardsAsString(): string
    {
        return implode(", ", array_map(fn ($card) => $card->getAsString(), $this->cards));
    }

    public function getDiscardedCardsAsString(): string
    {
        return implode(", ", array_map(fn ($card) => $card->getAsString(), $this->cardsDiscarded));
    }

    public function getCardsAsUnicode(): string
    {
        return implode("", array_map(fn ($card) => $card->getCardAsUnicode(), $this->cards));
    }

    public function getDiscardedCardsAsUnicode(): string
    {
        return implode("", array_map(fn ($card) => $card->getCardAsUnicode(), $this->cardsDiscarded));
    }

}
