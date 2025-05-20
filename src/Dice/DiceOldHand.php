<?php

namespace App\Dice;

use App\Dice\Dice;
use App\Dice\DiceGraphic;

class DiceOldHand
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

    public function roll(): void
    {
        foreach ($this->hand as $die) {
            $die->roll();
        }
    }

    public function getNumberDices(): int
    {
        return count($this->hand);
    }

    /**
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
