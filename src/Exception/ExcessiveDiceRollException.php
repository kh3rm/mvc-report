<?php

namespace App\Exception;

/**
 * An exception that is thrown when an excessive number of dice rolls is attempted.
 */
class ExcessiveDiceRollException extends \Exception
{
    /**
     * Constructor.
     *
     * @param string $message  The exception message.
     */
    public function __construct(string $message = "Sorry, cannot roll more than 99 dice!")
    {
        parent::__construct($message);
    }
}
