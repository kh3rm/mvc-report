<?php

namespace App\Card;

use App\Exception\HandOutOfBoundsException;

trait BlackjackCardHandling
{
    /** @var BlackjackCardHand[] An array that holds BlackjackCardHand objects. */
    protected array $hands;

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
     * Adds a card to the specified hand by its index.
     *
     * @param int $handIndex The index of the hand to which the card will be added.
     * @param Card $card The card to be added to the hand.
     *
     * @throws HandOutOfBoundsException if the handIndex is out of bounds.
     */
    public function addCardToHand(int $handIndex, Card $card): void
    {
        if ($handIndex < 0 || $handIndex >= $this->handCount) {
            throw new HandOutOfBoundsException();
        }

        $this->hands[$handIndex]->addCard($card);
    }

    /**
     * Marks the specified hand as inactive, effectively ending the player's turn on that hand.
     *
     * @param int $handIndex The index of the hand to be marked inactive.
     *
     * @throws HandOutOfBoundsException if the handIndex is out of bounds.
     */
    public function standHand(int $handIndex): void
    {
        if ($handIndex < 0 || $handIndex >= $this->handCount) {
            throw new HandOutOfBoundsException();
        }

        $this->hands[$handIndex]->setHandInactive();
    }



    /**
     * Splits the specified hand into two hands.
     *
     * @param int $handIndex The index of the hand to be split.
     * @param DeckOfCards52 $deck The deck used to take additional cards from.
     *
     * @throws HandOutOfBoundsException if the handIndex is out of bounds.
     */
    public function splitHand(int $handIndex, DeckOfCards52 $deck): void
    {
        if ($handIndex < 0 || $handIndex >= $this->handCount) {
            throw new HandOutOfBoundsException();
        }

        $handToSplit = $this->hands[$handIndex];
        $splittedHands = $handToSplit->splitHand($deck);

        array_splice($this->hands, $handIndex, 1, $splittedHands);
        $this->handCount = count($this->hands);
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
     * Adds new hands for the player. Accepts one or more BlackjackCardHand objects.
     *
     * @param BlackjackCardHand ...$newHands The hands to be added to the player.
     *
     * @return void
     */
    public function addHands(BlackjackCardHand ...$newHands): void
    {
        foreach ($newHands as $newHand) {
            $this->hands[] = $newHand;
            $this->handCount++;
        }
    }

    /**
     * Resets the hands, clearing the array of hands and resetting the hand count.
     */
    public function resetHands(): void
    {
        $this->hands = [];
        $this->handCount = 0;
    }

    /**
     * Gets the card in hand in Unicode-representation, separated by a comma.
     */
    public function getCardsInHandAsUnicode(): string
    {
        $unicodeHands = [];

        foreach ($this->hands as $hand) {
            $unicodeHands[] = $hand->getCardsAsUnicode();
        }

        return implode(", ", $unicodeHands);
    }
}
