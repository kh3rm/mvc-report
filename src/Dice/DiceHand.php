<?php

namespace App\Dice;

use App\Dice\Dice;

/**
 * DiceHand-Class, representing a dice-hand containing Dice-objects.
 */
class DiceHand
{
    /**
     * A property to hold mixed items.
     *
     * @var array<mixed>
     */
    private array $hand = [];

    public function add(Dice $die): void
    {
        $this->hand[] = $die;
    }

    /**
     * Roll dice hand.
     *
     */
    public function roll(): void
    {
        foreach ($this->hand as $die) {
            $die->roll();
        }
    }

    /**
     * Get number of dices.
     *
     * @return int
     */
    public function getNumberDices(): int
    {
        return count($this->hand);
    }

    /**
     * Get values.
     *
     * @return array<mixed>
     */
    public function getValues(): array
    {
        $values = [];
        foreach ($this->hand as $die) {
            $values[] = $die->getValue();
        }
        return $values;
    }

    /**
     * Get string.
     *
     * @return array<string>
     */
    public function getString(): array
    {
        $values = [];
        foreach ($this->hand as $die) {
            $values[] = $die->getAsString();
        }
        return $values;
    }
}
