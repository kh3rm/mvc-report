<?php

namespace App\Blackjack\BlackjackPlayer;

use App\Exception\NotEnoughChipsException;

/**
 * ChipHandling-Trait, contains all the player's chip handling-related logic.
 * Works agains $chips and $chipsInPlay attributes in the player's class.
 */
trait ChipHandlingTrait
{
    /**
     * Wager chips for the player by moving an amount from chips to chipsInPlay.
     * If no amount is specified, wagers a default amount of 100 times the number of hands.
     *
     * @param int|null $amount The amount of chips to wager. If null, defaults to 100 times the number of hands.
     *
     * @throws NotEnoughChipsException If the player does not have enough chips to wager the specified amount.
     */
    public function wagerChips(?int $amount = null): void
    {
        if ($amount === null) {
            $amount = $this->handsCount() * 100;
        }

        if ($this->chips < $amount) {
            throw new NotEnoughChipsException();
        }

        $this->chips -= $amount;
        $this->chipsInPlay += $amount;
    }

    /**
     * Add the chips awarded after round completion.
     */
    public function addChips(int $roundResultsChips): void
    {
        $this->chips = ($this->chips + $roundResultsChips);
    }

    /**
     * Get the chip-count.
     */
    public function getChipCount(): int
    {
        return $this->chips;
    }

    /**
     * Get the chips in play-count.
     */
    public function getChipsInPlayCount(): int
    {
        return $this->chipsInPlay;
    }

    /**
     * Resets the chips in play-count.
     */
    public function resetChipsInPlay(): void
    {
        $this->chipsInPlay = 0;
    }

}
