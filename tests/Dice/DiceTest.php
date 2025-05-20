<?php

namespace App\Dice;

use PHPUnit\Framework\TestCase;

use App\Exception\ExcessiveDiceValueException;
/**
 * Test cases for class Dice.
 */
class DiceTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateDice()
    {
        $die = new Dice();
        $this->assertInstanceOf("\App\Dice\Dice", $die);

        $res = $die->getAsString();
        $this->assertNotEmpty($res);
    }

    /**
     * Ascertain that an ExcessiveDiceRollException is thrown when a Dice is instantiated
     * with an invalid value (7 - only values between 1 and 6 are allowed).
     */
    public function testEDRException()
    {
        $this->expectException(ExcessiveDiceValueException::class);
        new Dice(7);

    }

}