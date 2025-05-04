<?php

namespace App\Exception;

class InvalidCardException extends \Exception
{
    public function __construct(string $message = "Sorry, you can only add instances of Card to the CardHand.", int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
