<?php

namespace App\PokerPatienceGS;

class PokerPatienceGrid
{
    /**
     * An array that holds the Card instances constituting the cards that have been placed
     * in the grid during gameplay.
     *
     * @var array $cardGrid An array of Card instances.
     */
    private $cardGrid;

    /**
     * Initializes the card grid with 25 null values.
     */
    public function __construct() {
        $this->cardGrid = array_fill(0, 25, null);
    }


    /**
     * Gets the current state of the card grid.
     *
     * @return array The current grid state.
     */
    public function getGrid(): array {
        return $this->cardGrid;
    }

    /**
     * Sets the grid to a given state based on the provided array of card values.
     *
     * @param array $newGrid An array of integers representing the new grid state
     * @return bool Returns true if the grid was successfully updated, otherwise false
     */
    public function setGrid(array $newGrid): bool {
        if (count($newGrid) !== 25) {
            return false;
        }

        $this->cardGrid = $newGrid;
        return true;
    }



    /**
     * Adds a card to the grid at the given index.
     *
     * @param int $cardInt The integer representation of the card to add
     * @param int $index The index position in the grid where the card should be placed
     * @return bool Returns true if the card was added successfully, otherwise false
     */
    public function addCardToGrid(int $cardInt, int $index): bool {

        if ($index < 0 || $index >= 25) {
            return false;
        }


        if ($this->cardGrid[$index] !== null && $this->cardGrid[$index] !== 0) {
            return false;
        }

        $this->cardGrid[$index] = $cardInt;
        return true;
    }






    /**
     * Resets the card-grid back to its initial empty state.
     */
    public function clearGrid(): void {
        $this->cardGrid = array_fill(0, 25, null);
    }

    public function establishEmptyScores(): array
    {
        return [
            "horizontal" => array_fill(0, 5, 0),
            "vertical" => array_fill(0, 5, 0),
            "current_score" => 0
        ];
    }

}