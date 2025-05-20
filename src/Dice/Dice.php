<?php

namespace App\Dice;

use App\Exception\ExcessiveDiceValueException;

class Dice
{
    protected int $value;

    public function __construct(int $number = -1)
    {
        if ($number === -1) {
            $this->value = random_int(1, 6);
            return;
        };

        if ($number < 1 || $number > 6) {
            throw new ExcessiveDiceValueException();
        };
    }

    public function roll(): int
    {
        $this->value = random_int(1, 6);
        return $this->value;
    }

    public function getAsString(): string
    {
        return "[{$this->value}]";
    }
}
