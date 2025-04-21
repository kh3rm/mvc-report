<?php

namespace App\Card;

// Built with the very helpful resource: https://en.wikipedia.org/wiki/Playing_cards_in_Unicode
class DeckOfCards
{
    protected $cards = [];
    protected $drawnCards = [];

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

    public function getDeckAsString(): string
    {
        return implode(', ', array_map(function($card) {
            return $card->getAsString();
        }, $this->cards));
    }


    public function getUnicodeCardsAsString(): string
    {
        return implode('', array_map(fn($card) => $card->getCardAsUnicode(), $this->cards));
    }

    public function shuffleDeckOfCards(): void
    {
        shuffle($this->cards);
    }


    public function getUnicodeStringOfDrawnCards(array $drawnCards): string
{
    return implode("", array_map(function ($card) {
        return $card->getCardAsUnicode();
    }, $drawnCards));
}

    public function getDrawnCards(): ?array
    {
        return $this->drawnCards;
    }


    public function getDeck(): array
    {
        return $this->cards;
    }

    public function getNumberOfCardsLeft(): int
    {
        return count($this->cards);
    }


    public function drawCard(): ?Card
    {
        if (empty($this->cards)) {
            return null;
        }

        $drawIndex = array_rand($this->cards);
        $drawnCard = $this->cards[$drawIndex];

        $this->drawnCards[] = $drawnCard;

        unset($this->cards[$drawIndex]);

        $this->cards = array_values($this->cards);

        return $drawnCard;
    }


    public function drawCards(int $amount): ?array
    {
        if ($amount < 1) {
            return null;
        }

        if (count($this->cards) < $amount) {
            return null;
        }

        $drawnCards = [];
        for ($i = 0; $i < $amount; $i++) {
            $drawnCards[] = $this->drawCard();
        }

        return $drawnCards;
    }
}
