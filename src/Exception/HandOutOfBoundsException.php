<?php

namespace App\Exception;

/**
 * An exception that is thrown when a hand index is out of bounds.
 */

class HandOutOfBoundsException extends \Exception
{
    /**
     * Constructor.
     *
     * @param string $message  The exception message.
     */
    public function __construct(string $message = "Sorry, hand index out of bound.")
    {
        parent::__construct($message);
    }
}
