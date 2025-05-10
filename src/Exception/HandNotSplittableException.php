<?php

namespace App\Exception;

class HandNotSplittableException extends \Exception
{
    public function __construct(string $message = "Sorry, the hand cannot be split because it is not splittable.", int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
