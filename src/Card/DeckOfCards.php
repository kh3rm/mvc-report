<?php

namespace App\Card;

// Built with the very helpful resource: https://en.wikipedia.org/wiki/Playing_cards_in_Unicode
class DeckOfCards
{
    /**
     * An array that holds the Card-instances constituting the deck, including jokers.
     *
     * @var Card[]  $cards  An array of Card instances.
     */
    protected $cards = [];

    /**
     * An array that holds the Card-instances that has been withdrawn/dealt from the deck.
     *
     * @var Card[]  $drawnCards  An array of Card instances.
     */
    protected $drawnCards = [];

    /**
     * Constructor that populates the DeckOfCards with the classical 52 cards + 2 jokers,
     * with all their complete, relevant properties.
     */
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
                $cardInt = ($suitSymbol === '♠') ? (100 + $value)
                            : (($suitSymbol === '♥') ? (200 + $value)
                            : (($suitSymbol === '♦') ? (300 + $value)
                            : (400 + $value)));

                $this->cards[] = new Card(
                    "$display$suitSymbol",
                    $cardInt,
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

    /**
     * Method that returns the $cards-array of all the Card-instances in $cards.
     *
     *  @return Card[] An array of Card instances.
     */
    public function getCards(): array
    {
        return $this->cards;
    }

    /**
     * Method that returns the $drawnCards-array of all the Card-instances
     * in $drawnCards.
     *
     *  @return Card[] An array of Card instances.
     */
    public function getDrawnCards(): ?array
    {
        return $this->drawnCards;
    }


    /**
     * Method that returns all the cards in the $cards as a string,
     * separated by a comma.
     *
     *  @return string A string of all the cards in the deck.
     */
    public function getCardsAsString(): string
    {
        return implode(', ', array_map(function ($card) {
            return $card->getAsString();
        }, $this->cards));
    }

    /**
     * Method that returns all the cards in the $drawnCards as a string,
     * separated by a comma.
     *
     *  @return string A string of all the drawn/dealt cards in the deck.
     */
    public function getDrawnCardsAsString(): string
    {
        return implode(', ', array_map(function ($card) {
            return $card->getAsString();
        }, $this->cards));
    }


    /**
     * Method that returns all the cards in the $cards as a string,
     * in Unicode representation.
     *
     *  @return string A string of all the cards in the deck in Unicode format.
     */
    public function getCardsUnicode(): string
    {
        return implode('', array_map(fn ($card) => $card->getCardAsUnicode(), $this->cards));
    }

    /**
     * Method that returns all the drawn cards as a string,
     * in Unicode representation.
     *
     * @return string A string of all the drawn/dealt cards in the deck in Unicode format.
     */
    public function getCardsDrawnUnicode(): string
    {
        return implode('', array_map(fn ($card) => $card->getCardAsUnicode(), $this->drawnCards));
    }


    /**
     * Method that takes a drawn-card-this-round-array with Card instances and returns
     * a string of its Unicode representation.
     *
     *  @param Card[] $drawnCards  An array of Card instances.
     *  @return string A string of all the drawn/dealt cards in the deck in Unicode format.
     */
    public function getUnicodeOfRoundCards(array $drawnCards): string
    {
        return implode("", array_map(function ($card) {
            return $card->getCardAsUnicode();
        }, $drawnCards));
    }



    /**
     * Shuffles the array of instances of Card in $cards, resulting in a new random array-index-order,
     * i.e, a (re)shuffled deck.
     */
    public function shuffleDeckOfCards(): DeckOfCards
    {
        shuffle($this->cards);
        return $this;
    }

    /**
     * Sorts the deck using the cards cardInt-property to its initial state, i.e first according to
     * suits, spades, hearts, diamonds,clubs, and then in ascending rank-order.
     */
    public function sortDeck(): DeckOfCards
    {
        usort($this->cards, function ($firstCard, $secondCard) {
            return $firstCard->getCardAsInt() <=> $secondCard->getCardAsInt();
        });
        return $this;
    }

    /**
     * Sorts the deck using the cards rank and suit, this time first according to rank in ascending order,
     * and within that sorting, according to suits.
     */
    public function sortDeckFirstByRankThenBySuit(): DeckOfCards
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

        return $this;
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


    /**
     * Method that draws/deals and returns {$number} of cards at random from $cards (and also
     * moves over to $drawnCards), using drawCard().
     *
     *  @return Card[] An array of the drawn Card-objects.
     */
    public function drawCards(int $number): ?array
    {
        if ($number < 1) {
            return null;
        }

        if (count($this->cards) < $number) {
            return null;
        }

        $drawnCards = [];

        for ($i = 0; $i < $number; $i++) {
            $drawnCard = $this->drawCard();
            if ($drawnCard !== null) {
                $drawnCards[] = $drawnCard;
            }
        }

        return count($drawnCards) > 0 ? $drawnCards : null;
    }
}
