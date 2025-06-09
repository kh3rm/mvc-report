<?php

namespace App\Deck;

use App\Card\Card;

/**
 * PopulateDeckHelpTrait - handles the population of a deck.
 */
trait PopulateDeckHelpTrait
{
    /**
     * getColorBySuit()-method that returns either the string 'red' or 'black'
     * depending on the suit.
     *
     * @return string
     */
    private function getColorBySuit(string $suitSymbol): string
    {
        return ($suitSymbol === '♥' || $suitSymbol === '♦') ? 'red' : 'black';
    }

    /**
     * calculateCardValue()-method used to generate the unique cardInt value
     * based on the suit and the value.
     *
     * @return int
     */
    private function calculateCardValue(string $suitSymbol, int $value): int
    {
        if ($suitSymbol === '♠') {
            return 100 + $value;
        }
        if ($suitSymbol === '♥') {
            return 200 + $value;
        }
        if ($suitSymbol === '♦') {
            return 300 + $value;
        }
        return 400 + $value;
    }

    /**
     * addJokers()-method used to add the jokers.
     */
    private function addJokers(): void
    {
        $this->cards[] = new Card("🂿", 0, "🂿", 'joker', 'black', 0);
        $this->cards[] = new Card("🃏︎", 0, "🃏︎", 'joker', 'black', 0);
    }

}
