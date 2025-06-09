<?php

namespace App\Tests\EvaluateHands\TestModules;

use App\PokerPatienceGS\EvaluateHands;

/**
 * Hand-score-test cases for the class EvaluateHands.
 */
trait EvaluateHandMultipleScoresTest
{
    /**
     * Evaluate a pair hand and asserting correct scoring (2).
     */
    public function testEvaluateHandsCorrectVertical()
    {

        $grid = array_fill(0, 25, 0);

        $grid[0] = '102';
        $grid[5] = '202';
        $grid[10] = '104';
        $grid[15] = '205';
        $grid[20] = '214';

        $evaluator = new EvaluateHands($grid);
        $result = $evaluator->evaluate();


        $this->assertEquals('2', $result['current_score']);
    }


    /**
     * Evaluate a pair hand and straight-hand vertically asserting correct scoring, 2+15=17.
     */
    public function testEvaluateHandsCorrectMultiple()
    {

        $grid = array_fill(0, 25, 0);

        $grid[0] = '102';
        $grid[5] = '202';
        $grid[10] = '104';
        $grid[15] = '205';
        $grid[20] = '214';

        $grid[1] = '110';
        $grid[6] = '111';
        $grid[11] = '212';
        $grid[16] = '213';
        $grid[21] = '214';


        $evaluator = new EvaluateHands($grid);
        $result = $evaluator->evaluate();

        echo "Grid: ";
        print_r($grid);
        echo "Result: ";
        print_r($result);



        $this->assertEquals('17', $result['current_score']);
    }


    /**
     * Evaluate a pair hand and straight-hand vertically, and a flush hand horizontally,
     * asserting correct scoring, 2+15+20=37.
     */
    public function testEvaluateHandsCorrectMultipleFull()
    {

        $grid = array_fill(0, 25, 0);

        $grid[0] = '102';
        $grid[5] = '202';
        $grid[10] = '104';
        $grid[15] = '205';
        $grid[20] = '214';

        $grid[1] = '110';
        $grid[6] = '111';
        $grid[11] = '212';
        $grid[16] = '213';
        $grid[21] = '214';


        $grid[2] = '105';
        $grid[3] = '106';
        $grid[4] = '107';



        $evaluator = new EvaluateHands($grid);
        $result = $evaluator->evaluate();

        echo "Grid: ";
        print_r($grid);
        echo "Result: ";
        print_r($result);



        $this->assertEquals('37', $result['current_score']);
    }

/**
 * Evaluate 4 straight-flush dream hands horizontally, including 5 four of a kind vertically,
 * plus an extra straight flush as a cherry on top on the bottom row.
 * asserting correct scoring (150*4) + (50*5) + 75 = 925
 */
public function testDreamHandCorrectMultipleFull()
{
    $grid = array_fill(0, 25, 0);

    $grid[0] = '110';
    $grid[1] = '111';
    $grid[2] = '112';
    $grid[3] = '113';
    $grid[4] = '114';

    $grid[5] = '210';
    $grid[6] = '211';
    $grid[7] = '212';
    $grid[8] = '213';
    $grid[9] = '214';

    $grid[10] = '310';
    $grid[11] = '311';
    $grid[12] = '312';
    $grid[13] = '313';
    $grid[14] = '314';

    $grid[15] = '410';
    $grid[16] = '411';
    $grid[17] = '412';
    $grid[18] = '413';
    $grid[19] = '414';

    $grid[20] = '102';
    $grid[21] = '103';
    $grid[22] = '104';
    $grid[23] = '105';
    $grid[24] = '106';

    $evaluator = new EvaluateHands($grid);
    $result = $evaluator->evaluate();


    $this->assertEquals('925', $result['current_score']);
}



}

