<?php

namespace App\Dice;

use App\Exception\ExcessiveDiceValueException;

class Dice
{
    protected int $value;

    public function __construct(int $nr = -1)
    {
        if ($nr === -1) {
            $this->value = random_int(1, 6);
            return;
        };

        if ($nr < 1 || $nr > 6) {
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