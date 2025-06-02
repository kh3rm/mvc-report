<?php

namespace App\Blackjack\BlackjackPlayer;

/**
 * TurnHandling-Trait, contains all the player's turn handling-related logic.
 * Works against the $activeTurn attribute in the player's class.
 */
trait TurnHandlingTrait
{
    /**
     * Get the boolean-value of activeTurn.
     *
     * @return bool
     */
    public function isActiveTurn(): bool
    {
        return $this->activeTurn;
    }

    /**
     * Activate the player/dealer turn.
     */
    public function activateTurn(): void
    {
        $this->activeTurn = true;
    }

    /**
     * Dectivate the player/dealer turn.
     */
    public function deactivateTurn(): void
    {
        $this->activeTurn = false;
    }

    /**
     * Checks if all of the player's hands are inactive, and if so, updates the activeTurn attribute
     * accordingly.
     */
    public function activeTurnStatus(): void
    {
        $noHandsActive = true;

        foreach ($this->hands as $hand) {
            if ($hand->isHandActive()) {
                $noHandsActive = false;
                break;
            }
        }

        $this->activeTurn = !$noHandsActive;
    }


}
