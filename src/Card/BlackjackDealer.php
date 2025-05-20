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


}
