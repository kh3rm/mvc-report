<?php

namespace App\Blackjack\BlackjackPlayer;

use App\Blackjack\BlackjackCardHand\BlackjackCardHand;
use App\Exception\NoHandToRetrieveCardsException;

/**
 * BlackjackCardHandling-trait, containing methods pertaining to the handling of
 * BlackjackCardHands.
 */
trait BlackjackCardHandling
{
    /** @var BlackjackCardHand[] An array that holds BlackjackCardHand objects. */
    protected array $hands = [];

    /** @var int The count of hands. */
    protected int $handCount = 0;


    /**
     * Getter that retrieves all the player hands.
     *
     * @return BlackjackCardHand[] an array of BlackjackCardHands.
     */
    public function getHands(): array
    {
        return $this->hands;
    }


    /**
     * Updates the status of all the player's hands.
     */
    public function updateHandsStatus(): void
    {
        foreach ($this->hands as $hand) {
            $hand->updateHandStatus();
        }
    }

    /**
     * Returns the count of active hands for the player.
     *
     * @return int The number of active hands.
     */
    public function activeHandsCount(): int
    {
        $activeCount = 0;

        foreach ($this->hands as $hand) {
            if ($hand->isHandActive()) {
                $activeCount++;
            }
        }

        return $activeCount;
    }



    /**
     * Returns the total number of hands held by the player.
     *
     * @return int The count of hands.
     */
    public function handsCount(): int
    {
        return $this->handCount;
    }



    /**
     * Returns the cards in Hand as Unicode-representation.
     */
    public function getCardsInHandAsUnicode(): string
    {
        if (empty($this->hands)) {
            throw new NoHandToRetrieveCardsException();
        }

        $unicodeRepr = '';

        foreach ($this->hands as $hand) {
            $unicodeRepr .= $hand->getCardsAsUnicode();
        }

        return $unicodeRepr;
    }
}
