<?php

namespace App\Card;

class DeckOfCardsOld
{
    protected $cards = [];


    public function __construct()
    {

        $suits = ['♠', '♥', '♦', '♣'];
        $values = [
            2, 3, 4, 5, 6, 7, 8, 9, 10,
            'J', 'Q', 'K', 'A'
        ];
        foreach ($suits as $suit) {
            foreach ($values as $value) {
                $this->cards[] = new Card("$value$suit");
            }
        }

        $this->cards[] = new Card("🂿");
        $this->cards[] = new Card("🃏︎");
        $this->cards[] = new Card("🃟");
    }


    public function getCards(): array
    {
        return $this->cards;
    }

    public function getDeckAsString(): string
    {
        return implode(', ', array_map(function($card) {
            return $card->getAsString();
        }, $this->cards));
    }
}