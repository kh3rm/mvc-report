<?php

namespace App\Exception;

/**
 * An exception that is thrown when Dealer/Player tries to wager more chips than is available.
 */
class NotEnoughChipsException extends \Exception
{
    /**
      * Constructor.
      *
      * @param string $message  The exception message.
      */
    public function __construct(string $message = "Sorry, not enough chips available to wager that amount.")
    {
        parent::__construct($message);
    }
}
