<?php

namespace App\Card;

use App\Exception\NotEnoughChipsException;

class BlackjackDealer extends BlackjackPlayer
{
    /**
     * Constructor for Dealer.
     *
     * @param BlackjackCardHand[] $cardsHand
     * @param int $chips
     * @param string $name
     */
    public function __construct(array $cardsHand, int $chips = 1000, string $name = "Dealer")
    {
        parent::__construct($name, $cardsHand, $chips);
        $this->deactivateTurn();
    }


    /**
     * Wager the given amount, based on the player's corresponding figure, and move that amount
     * from chips to chipsInPlay (in limbo, awaiting round resolution).
     *
     * @throws NotEnoughChipsException If the dealer does not have enough chips to wager.
     */
    public function dealerWagerChips(int $wagerAmount): void
    {

        if ($this->chips < $wagerAmount) {
            throw new NotEnoughChipsException();
        }

        $this->chips -= $wagerAmount;
        $this->chipsInPlay += $wagerAmount;
    }

}
