<?php

namespace App\Exception;

class NoHandToRetrieveCardsException extends \Exception
{
    public function __construct(string $message = "Sorry, the player currently has no hands to retrieve cards from.", int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
