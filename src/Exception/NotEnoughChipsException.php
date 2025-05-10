<?php

namespace App\Exception;

class NotEnoughChipsException extends \Exception
{
    public function __construct(string $message = "Sorry, not enough chips available to wager that amount.", int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
