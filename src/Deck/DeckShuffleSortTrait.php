<?php

namespace App\Deck;

/**
 * DeckShuffleSortTrait that handles the sorting- and shuffling-functionality
 * of a deck.
 */
trait DeckShuffleSortTrait
{
    /**
     * Shuffles the array of instances of Card in $cards, resulting in a new random array-index-order,
     * i.e, a (re)shuffled deck.
     */
    public function shuffleDeckOfCards(): void
    {
        shuffle($this->cards);
    }

    /**
     * Sorts the deck using the cards cardInt-property to its initial state, i.e first according to
     * suits, spades, hearts, diamonds,clubs, and then in ascending rank-order.
     */
    public function sortDeck(): void
    {
        usort($this->cards, function ($firstCard, $secondCard) {
            return $firstCard->getCardAsInt() <=> $secondCard->getCardAsInt();
        });
    }

    /**
     * Sorts the deck using the cards rank and suit, this time first according to rank in ascending order,
     * and within that sorting, according to suits.
     */
    public function sortDeckFirstByRankThenBySuit(): void
    {
        $suitsRank = [
            'spade' => 1,
            'heart' => 2,
            'diamond' => 3,
            'club' => 4
        ];

        usort($this->cards, function ($firstCard, $secondCard) use ($suitsRank) {
            if ($firstCard->getRank() === $secondCard->getRank()) {
                return $suitsRank[$firstCard->getSuit()] <=> $suitsRank[$secondCard->getSuit()];
            }
            return $firstCard->getRank() <=> $secondCard->getRank();
        });
    }
}
