<?php

namespace App\Dice;

use App\Exception\ExcessiveDiceValueException;

/**
 * Dice Class, representing a dice with a value between 1 and 6.
 */
class Dice
{
    protected int $value;

    /**
     * Constructor for Dice.
     *
     * @param int $number
     */
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

    /**
    * Roll dice.
    *
    */
    public function roll(): int
    {
        $this->value = random_int(1, 6);
        return $this->value;
    }

    /**
     * Get dice as string.
     *
     */
    public function getAsString(): string
    {
        return "[{$this->value}]";
    }
}
