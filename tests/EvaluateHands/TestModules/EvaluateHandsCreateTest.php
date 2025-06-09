<?php

namespace App\Tests\EvaluateHands\TestModules;

use App\Exception\IncorrectGridFormatException;
use App\PokerPatienceGS\EvaluateHands;


/**
 * Create/instantiation-test cases for the class EvaluateHands.
 */
trait EvaluateHandsCreateTest
{
    /**
     * Construct object with a valid 25-entry-array and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateEvaluateHands()
    {
        $grid = array_fill(0, 25, 0);
        $evaluator = new EvaluateHands($grid);
        $this->assertInstanceOf(EvaluateHands::class, $evaluator);
        $this->assertNotEmpty($evaluator);
    }

    /**
     * Ascertain that the custom IncorrectGridFormatException-error is thrown  when the grid
     * supplied does not contain exactly 25 values.
     */
    public function testCreateEvaluateHandsInvalidGrid()
    {
        $this->expectException(IncorrectGridFormatException::class);
        new EvaluateHands(array_fill(0, 24, 0));
    }

    /**
     * Construct object with a valid 25-entry-array and verify that the object,
     * evaluate it with the evaluate()-method, and ascertain that it returns the correct
     * structures.
     */
    public function testEvaluateHandsReturnsCorrectStructures()
    {
        $grid = array_fill(0, 25, 0);
        $evaluator = new EvaluateHands($grid);
        $result = $evaluator->evaluate();

        $this->assertArrayHasKey('horizontal', $result);
        $this->assertArrayHasKey('vertical', $result);
        $this->assertArrayHasKey('current_score', $result);

        $this->assertIsArray($result['horizontal']);
        $this->assertIsArray($result['vertical']);
        $this->assertIsInt($result['current_score']);
    }


    /**
     * Construct object with a valid 25-entry-array and verify that the object,
     * evaluate it with the evaluate()-method, and ascertain that it returns the correct
     * JSON-friendly structure.
     */
    public function testEvaluateCorrectFormatting()
    {
        $grid = array_fill(0, 25, 0);
        $evaluator = new EvaluateHands($grid);
        $result = $evaluator->evaluate();

        $expectedEmptyFormat = [
            "horizontal" => [
                0,
                0,
                0,
                0,
                0
            ],
            "vertical" => [
                0,
                0,
                0,
                0,
                0
            ],
            "current_score" => 0
        ];

        $this->assertEquals($result, $expectedEmptyFormat);
    }

}