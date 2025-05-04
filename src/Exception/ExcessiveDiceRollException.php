<?php

namespace App\Exception;

class ExcessiveDiceRollException extends \Exception
{
    public function __construct(string $message = "Can not roll more than 99 dices!", int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
