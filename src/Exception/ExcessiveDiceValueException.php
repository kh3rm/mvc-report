<?php

namespace App\Exception;

class ExcessiveDiceValueException extends \Exception
{
    public function __construct(string $message = "Sorry, the dice-value must be between 1 and 6.", int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
