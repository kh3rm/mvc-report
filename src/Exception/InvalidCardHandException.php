<?php

namespace App\Exception;

class InvalidCardHandException extends \Exception
{
    public function __construct(string $message = "Sorry, you can only add instances of BlackjackCardHand to the dealer/player-hand(s).", int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
