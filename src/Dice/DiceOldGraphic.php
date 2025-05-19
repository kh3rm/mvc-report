<?php

namespace App\Dice;

class DiceOldGraphic extends Dice
{
    /**
     *
     * @var string[] $representation An array of strings representing the Unicode-dice values.
     */
    private array $representation = [
        '⚀',
        '⚁',
        '⚂',
        '⚃',
        '⚄',
        '⚅',
    ];

    public function __construct()
    {
        parent::__construct();
    }


    public function getAsString(): string
    {
        return $this->representation[$this->value - 1];
    }
}
