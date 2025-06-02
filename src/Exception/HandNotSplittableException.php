<?php

namespace App\Exception;

/**
 * An exception that is thrown when an hand is not splittable.
 */
class HandNotSplittableException extends \Exception
{
    /**
     * Constructor.
     *
     * @param string $message  The exception message.
     */
    public function __construct(string $message = "Sorry, the hand cannot be split because it is not splittable.")
    {
        parent::__construct($message);
    }
}
