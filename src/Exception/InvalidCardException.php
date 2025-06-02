<?php

namespace App\Exception;

/**
 * An exception that is thrown when a non Card-object is attempted to be added to
 * a CardHand.
 */

class InvalidCardException extends \Exception
{
    /**
     * Constructor.
     *
     * @param string $message  The exception message.
     */
    public function __construct(string $message = "Sorry, you can only add instances of Card to the CardHand.")
    {
        parent::__construct($message);
    }
}
