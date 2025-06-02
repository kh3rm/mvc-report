<?php

namespace App\Dice;

/**
 * DiceGraphic-Class, extends Dice, representing a graphic dice with a value between 1 and 6.
 */
class DiceGraphic extends Dice
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

    /**
     * Constructor for DiceGraphic.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get as string.
     *
     * @return string
     */
    public function getAsString(): string
    {
        return $this->representation[$this->value - 1];
    }
}
