<?php

namespace App\Card;

class DeckOfCardsOldd
{
    protected $cards = [];

    public function __construct()
    {
        $suits = ['♠', '♥', '♦', '♣'];
        $values = [
            2 => '2',
            3 => '3',
            4 => '4',
            5 => '5',
            6 => '6',
            7 => '7',
            8 => '8',
            9 => '9',
            10 => '10',
            11 => 'J',
            12 => 'Q',
            13 => 'K',
            14 => 'A'
        ];
        $unicodeCards = [
            '♠' => ['🂢', '🂣', '🂤', '🂥', '🂦', '🂧', '🂨', '🂩', '🂪', '🂫', '🂭', '🂮', '🂡'],
            '♥' => ['🂲', '🂳', '🂴', '🂵', '🂶', '🂷', '🂸', '🂹', '🂺', '🂻', '🂽', '🂾', '🂱'],
            '♦' => ['🃂', '🃃', '🃄', '🃅', '🃆', '🃇', '🃈', '🃉', '🃊', '🃋', '🃍', '🃎', '🃁'],
            '♣' => ['🃒', '🃓', '🃔', '🃕', '🃖', '🃗', '🃘', '🃙', '🃚', '🃛', '🃝', '🃞', '🃑']
        ];

        foreach ($suits as $suit) {
            $baseValue = match ($suit) {
                '♠' => 100,
                '♥' => 200,
                '♦' => 300,
                '♣' => 400,
            };

            foreach ($values as $value => $display) {
                $cardValue = $baseValue + $value;
                $this->cards[] = new Card("$display$suit", $cardValue, $unicodeCards[$suit][$value - 2]);
            }
        }

        $this->cards[] = new Card("🂿", 53, "🂿");
        $this->cards[] = new Card("🃏︎", 54, "🃏︎");
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

    public function getUnicodeCardsAsString(): string
    {
        $unicodeCards = array_map(function($card) {
            return $card->getCardAsUnicode();
        }, $this->cards);

        $unicodeCardsString = implode('_', $unicodeCards);
        return $unicodeCardsString;
    }
}
