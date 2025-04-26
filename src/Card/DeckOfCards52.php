<?php

namespace App\Card;

class DeckOfCards52 extends DeckOfCards
{
    public function __construct()
    {
        parent::__construct();

        $this->removeJokers();
    }

    private function removeJokers(): void
    {
        $this->cards = array_filter($this->cards, function ($card) {
            return $card->getCardAsInt() !== 0;
        });

        $this->cards = array_values($this->cards);
    }
}
