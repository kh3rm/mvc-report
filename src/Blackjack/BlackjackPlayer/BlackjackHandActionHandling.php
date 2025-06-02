<?php

namespace App\Blackjack\BlackjackPlayer;

use App\Card\Card;
use App\Deck\DeckOfCards52;
use App\Blackjack\BlackjackCardHand\BlackjackCardHand;
use App\Exception\HandOutOfBoundsException;
use App\Exception\HandNotSplittableException;

/**
 * BlackjackHandActionHandling-trait, containing methods pertaining to the handling of
 * BlackjackCardHand-actions.
 */
trait BlackjackHandActionHandling
{
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

        if (!$handToSplit->isHandActive()) {
            throw new HandNotSplittableException("Sorry, cannot split an inactive hand.");
        }


        $splittedHands = $handToSplit->splitHand($deck);

        array_splice($this->hands, $handIndex, 1, $splittedHands);
        $this->handCount = count($this->hands);
    }


    /**
     * Resets the hands, clearing the array of hands and resetting the hand count.
     */
    public function resetHands(): void
    {
        $this->hands = [];
        $this->handCount = 0;
    }

}
