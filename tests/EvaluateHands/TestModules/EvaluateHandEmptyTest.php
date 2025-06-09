<?php

namespace App\Tests\EvaluateHands\TestModules;

use App\PokerPatienceGS\EvaluateHands;
use App\Exception\IncorrectGridFormatException;

/**
 * Empty hand-score-test cases for the class EvaluateHands.
 */
trait EvaluateHandEmptyTest
{
    /**
     * Test that handOnePair throws IncorrectGridFormatException for empty values.
     */
    public function testHandOnePairThrowsExceptionForEmptyValues()
    {
        $this->expectException(IncorrectGridFormatException::class);
        $evaluator = new EvaluateHands([]);
        $evaluator->handOnePair([]);
    }

    /**
     * Test that handTwoPairs throws IncorrectGridFormatException for empty values.
     */
    public function testHandTwoPairsThrowsExceptionForEmptyValues()
    {
        $this->expectException(IncorrectGridFormatException::class);
        $evaluator = new EvaluateHands([]);
        $evaluator->handTwoPairs([]);
    }

    /**
     * Test that handThreeOfAKind throws IncorrectGridFormatException for empty values.
     */
    public function testHandThreeOfAKindThrowsExceptionForEmptyValues()
    {
        $this->expectException(IncorrectGridFormatException::class);
        $evaluator = new EvaluateHands([]);
        $evaluator->handThreeOfAKind([]);
    }

    /**
     * Test that handStraight throws IncorrectGridFormatException for empty values.
     */
    public function testHandStraightThrowsExceptionForEmptyValues()
    {
        $this->expectException(IncorrectGridFormatException::class);
        $evaluator = new EvaluateHands([]);
        $evaluator->handStraight([]);
    }

    /**
     * Test that handFlush throws IncorrectGridFormatException for empty values.
     */
    public function testHandFlushThrowsExceptionForEmptyValues()
    {
        $this->expectException(IncorrectGridFormatException::class);
        $evaluator = new EvaluateHands([]);
        $evaluator->handFlush([]);
    }

    /**
     * Test that handFullHouse throws IncorrectGridFormatException for empty values.
     */
    public function testHandFullHouseThrowsExceptionForEmptyValues()
    {
        $this->expectException(IncorrectGridFormatException::class);
        $evaluator = new EvaluateHands([]);
        $evaluator->handFullHouse([]);
    }

    /**
     * Test that handFourOfAKind throws IncorrectGridFormatException for empty values.
     */
    public function testHandFourOfAKindThrowsExceptionForEmptyValues()
    {
        $this->expectException(IncorrectGridFormatException::class);
        $evaluator = new EvaluateHands([]);
        $evaluator->handFourOfAKind([]);
    }

    /**
     * Test that handStraightFlush throws IncorrectGridFormatException for empty values.
     */
    public function testHandStraightFlushThrowsExceptionForEmptyValues()
    {
        $this->expectException(IncorrectGridFormatException::class);
        $evaluator = new EvaluateHands([]);
        $evaluator->handStraightFlush([], []);
    }

    /**
     * Test that handRoyalFlush throws IncorrectGridFormatException for empty values.
     */
    public function testHandRoyalFlushThrowsExceptionForEmptyValues()
    {
        $this->expectException(IncorrectGridFormatException::class);
        $evaluator = new EvaluateHands([]);
        $evaluator->handRoyalFlush([], []);
    }
}
