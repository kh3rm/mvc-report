<?php

namespace App\Exception;

/**
 * An exception that is thrown when a dice value is not between 1 and 6.
 */
class ExcessiveDiceValueException extends \Exception
{
    /**
     * Constructor.
     *
     * @param string $message  The exception message.
     */
    public function __construct(string $message = "Sorry, the dice-value must be between 1 and 6.")
    {
        parent::__construct($message);
    }
}
