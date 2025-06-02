<?php

namespace App\Exception;

/**
 * An exception that is thrown when a non BlackjackCardHand-object is attempted to be added to
 * a BlackjackPlayer/BlackjackDealer.
 */

class InvalidCardHandException extends \Exception
{
    /**
     * Constructor.
     *
     * @param string $message  The exception message.
     */
    public function __construct(string $message = "Sorry, you can only add instances of BlackjackCardHand to the dealer/player-hand(s).")
    {
        parent::__construct($message);
    }
}
