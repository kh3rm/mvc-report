<?php

namespace App\Card;

class DeckOfCards
{
    protected $cards = [];

    public function __construct()
    {
        $suits = [
            '♠' => 'spade',
            '♥' => 'heart',
            '♦' => 'diamond',
            '♣' => 'club'
        ];

        $values = [
            2 => '2', 3 => '3', 4 => '4', 5 => '5',
            6 => '6', 7 => '7', 8 => '8', 9 => '9',
            10 => '10', 11 => 'J', 12 => 'Q', 13 => 'K', 14 => 'A'
        ];

        $unicodeCards = [
            '♠' => ['🂢', '🂣', '🂤', '🂥', '🂦', '🂧', '🂨', '🂩', '🂪', '🂫', '🂭', '🂮', '🂡'],
            '♥' => ['🂲', '🂳', '🂴', '🂵', '🂶', '🂷', '🂸', '🂹', '🂺', '🂻', '🂽', '🂾', '🂱'],
            '♦' => ['🃂', '🃃', '🃄', '🃅', '🃆', '🃇', '🃈', '🃉', '🃊', '🃋', '🃍', '🃎', '🃁'],
            '♣' => ['🃒', '🃓', '🃔', '🃕', '🃖', '🃗', '🃘', '🃙', '🃚', '🃛', '🃝', '🃞', '🃑']
        ];

        foreach ($suits as $suitSymbol => $suitString) {
            $color = ($suitSymbol === '♥' || $suitSymbol === '♦') ? 'red' : 'black';

            foreach ($values as $value => $display) {
                $cardValue = ($suitSymbol === '♠') ? (100 + $value)
                            : (($suitSymbol === '♥') ? (200 + $value)
                            : (($suitSymbol === '♦') ? (300 + $value)
                            : (400 + $value)));

                $this->cards[] = new Card(
                    "$display$suitSymbol",
                    $cardValue,
                    $unicodeCards[$suitSymbol][$value - 2],
                    $suitString,
                    $color,
                    $value
                );
            }
        }

        $this->cards[] = new Card("🂿", 0, "🂿", 'joker', 'black', 0);
        $this->cards[] = new Card("🃏︎", 0, "🃏︎", 'joker', 'black', 0);
    }

    public function getCards(): array
    {
        return $this->cards;
    }

    public function getUnicodeCardsAsString(): string
    {
        return implode('', array_map(fn($card) => $card->getCardAsUnicode(), $this->cards));
    }

    public function shuffleDeckOfCards(): void
    {
        shuffle($this->cards);
    }


    public function getDeck(): array
    {
        return $this->cards;
    }
}
