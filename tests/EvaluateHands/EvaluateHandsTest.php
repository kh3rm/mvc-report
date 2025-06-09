<?php

namespace App\Tests\EvaluateHands;
use App\Tests\EvaluateHands\TestModules\EvaluateHandScoresTest;
use App\Tests\EvaluateHands\TestModules\EvaluateHandsCreateTest;
use App\Tests\EvaluateHands\TestModules\EvaluateHandMultipleScoresTest;
use App\Tests\EvaluateHands\TestModules\EvaluateHandEmptyTest;

use PHPUnit\Framework\TestCase;

use App\Card\Card;
use App\Blackjack\BlackjackPlayer\BlackjackDealer;
use App\Blackjack\BlackjackCardHand\BlackjackCardHand;

class EvaluateHandsTest extends TestCase
{
    use EvaluateHandsCreateTest;
    use EvaluateHandScoresTest;
    use EvaluateHandMultipleScoresTest;
    use EvaluateHandEmptyTest;

}