<?php

namespace App\Tests\EvaluateHands\TestModules;

use App\Exception\IncorrectGridFormatException;
use App\PokerPatienceGS\EvaluateHands;

/**
 * Hand-score-test cases for the class EvaluateHands.
 */
trait EvaluateHandScoresTest
{

    /**
     * Evaluate a non-scoring and asserting correct scoring (0).
     */
    public function testEvaluateHandsNoScore()
    {
        $grid = array_merge(['102', '210', '104', '206', '214'], array_fill(0, 20, 0));
        $evaluator = new EvaluateHands($grid);
        $result = $evaluator->evaluate();

        $this->assertEquals('0', $result['current_score']);
    }




    /**
     * Evaluate a pair hand and asserting correct scoring (2).
     */
    public function testEvaluateHandsCorrectPairScore()
    {
        $grid = array_merge(['102', '202', '104', '205', '214'], array_fill(0, 20, 0));
        $evaluator = new EvaluateHands($grid);
        $result = $evaluator->evaluate();

        $this->assertEquals('2', $result['current_score']);
    }


    /**
     * Evaluate a pair hand and asserting correct scoring (2).
     */
    public function testEvaluateHandsCorrectTwoPairScore()
    {
        $grid = array_merge(['102', '202', '104', '204', '214'], array_fill(0, 20, 0));

        $evaluator = new EvaluateHands($grid);
        $result = $evaluator->evaluate();

        $this->assertEquals('5', $result['current_score']);
    }




    /**
     * Evaluate a three of a kind hand and asserting correct scoring (10).
     */
    public function testEvaluateHandsCThreeOfAKindScore()
    {
        $grid = array_merge(['102', '202', '302', '204', '214'], array_fill(0, 20, 0));

        $evaluator = new EvaluateHands($grid);
        $result = $evaluator->evaluate();

        $this->assertEquals('10', $result['current_score']);
    }




    /**
     * Evaluate a straight hand and asserting correct scoring (15).
     */
    public function testEvaluateHandsCorrectStraightScore()
    {
        $grid = array_merge(['102', '103', '104', '205', '214'], array_fill(0, 20, 0));

        $evaluator = new EvaluateHands($grid);
        $result = $evaluator->evaluate();

        $this->assertEquals('15', $result['current_score']);
    }



    /**
     * Test edge case: Evaluating a flush hand and asserting correct score (20).
     */
    public function testEvaluateHandsFlushScore()
    {
        $grid = array_merge([102, 106, 107, 108, 110], array_fill(0, 20, 0));

        $evaluator = new EvaluateHands($grid);
        $result = $evaluator->evaluate();

        $this->assertEquals('20', $result['current_score']);
    }


    /**
     * Test edge case: Evaluating a full house hand and asserting correct score (25).
     */
    public function testEvaluateHandsFullHouseScore()
    {
        $grid = array_merge([202, 302, 402, 303, 403], array_fill(0, 20, '01'));

        $evaluator = new EvaluateHands($grid);
        $result = $evaluator->evaluate();

        $this->assertEquals('25', $result['current_score']);
    }


    /**
     * Test edge case: Evaluating a four of a kind hand and asserting correct score (50).
     */
    public function testEvaluateHandsFourOfAKindScore()
    {
        $grid = array_merge([202, 302, 402, 102, 403], array_fill(0, 20, '01'));

        $evaluator = new EvaluateHands($grid);
        $result = $evaluator->evaluate();

        $this->assertEquals('50', $result['current_score']);
    }

    /**
     * Test edge case: Evaluating a Straight Flush hand and asserting correct score (75).
     */
    public function testEvaluateHandsStraightFlushScore()
    {
        $grid = array_merge([202, 203, 204, 205, 206], array_fill(0, 20, '01'));

        $evaluator = new EvaluateHands($grid);
        $result = $evaluator->evaluate();

        $this->assertEquals('75', $result['current_score']);
    }


    /**
     * Test edge case: Evaluating a Royal Straight Flush hand and asserting correct score (150).
     */
    public function testEvaluateHandsRoyalStraightFlushScore()
    {
        $grid = array_merge([210, 211, 212, 213, 214], array_fill(0, 20, '01'));

        $evaluator = new EvaluateHands($grid);
        $result = $evaluator->evaluate();

        $this->assertEquals('150', $result['current_score']);
    }



}
