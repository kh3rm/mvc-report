<?php

namespace App\Exception;

/**
 * An exception that is thrown when an excessive number of dice rolls is attempted.
 */
class IncorrectGridFormatException extends \Exception
{
    /**
     * Constructor.
     *
     * @param string $message  The exception message.
     */
    public function __construct(string $message = "Sorry, the grid must contain exactly 25 values.")
    {
        parent::__construct($message);
    }
}
