<?php

namespace App\Exception;

/**
 * An exception that is thrown when one tries to retrieve cards from a Player who has
 * no cards in his/her hand.
 */
class NoHandToRetrieveCardsException extends \Exception
{
    /**
      * Constructor.
      *
      * @param string $message  The exception message.
      */
    public function __construct(string $message = "Sorry, the player currently has no hands to retrieve cards from.")
    {
        parent::__construct($message);
    }
}
