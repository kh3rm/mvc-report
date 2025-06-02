<?php

namespace App\Blackjack\BlackjackCardHand;

/**
 * ActiveHandHandlingTrait-Trait, contains all the BlackjackCardHand's
 * active turn handling.
 *
 * Works against the attribute $handActive.
 */
trait ActiveHandHandlingTrait
{
    /**
     * Returns the active status of the hand.
     *
     * @return bool
     */
    public function isHandActive(): bool
    {
        return $this->handActive;
    }


    /**
     * Returns the inactive status of the hand.
     *
     * @return bool
     */
    public function isHandInactive(): bool
    {
        return !$this->handActive;
    }



    /**
     * Sets the handActive-attribute to false.
     *
     */
    public function setHandInactive(): void
    {
        $this->handActive = false;
    }



    /**
     * Checks the status of the hand and updates it if necessary.
     * Sets the hand to inactive if the current hand value exceeds 20.
     */
    public function updateHandStatus(): void
    {
        if ($this->currentHandValue() > 20) {
            $this->setHandInactive();
        }
    }

}
