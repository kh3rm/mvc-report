<?php

namespace App\Exception;

class HandOutOfBoundsException extends \Exception
{
    public function __construct(string $message = "Sorry, hand index out of bound.")
    {
        parent::__construct($message);
    }
}
