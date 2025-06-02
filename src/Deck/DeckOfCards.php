<?php

namespace App\Deck;

use App\Deck\UnicodeRepresentationTrait;
use App\Deck\DeckShuffleSortTrait;
use App\Deck\GetCardFromDeckTrait;
use App\Deck\DrawCardFromDeckTrait;
use App\Deck\PopulateDeckHelpTrait;
use App\Card\Card;

/**
 * DeckOfCards-Class, representing a classical deck of 52 regular cards, + 2 jokers.
 */
class DeckOfCards
{
    use DeckShuffleSortTrait;
    use UnicodeRepresentationTrait;
    use GetCardFromDeckTrait;
    use DrawCardFromDeckTrait;
    use PopulateDeckHelpTrait;
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
     * Constructor that by default populates the DeckOfCards with the
     * classical 52 cards + 2 jokers using the populateDeck-method.
     */
    public function __construct()
    {

        $this->populateDeckClassical();
    }

    /**
     * populateDeckClassical()-method that populates the DeckOfCards with the
     * classical 52 cards + 2 jokers.
     */
    public function populateDeckClassical(): void
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
            $color = $this->getColorBySuit($suitSymbol);

            foreach ($values as $value => $display) {
                $cardInt = $this->calculateCardValue($suitSymbol, $value);
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

        $this->addJokers();

    }



    /**
     * Method that adds a Card object to the $cards array.
     *
     * @param Card $card The Card object to add to the deck.
     */
    public function addCard(Card $card): void
    {
        $this->cards[] = $card;
    }


    /**
     * Gets the number of cards left in the deck (int).
     */
    public function getNumberOfCardsLeft(): int
    {
        return count($this->cards);
    }


    /**
     * Method that empties the deck of all its cards.
     */
    public function emptyDeck(): void
    {
        $this->cards = [];
        $this->drawnCards = [];
    }
}
