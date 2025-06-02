<?php

namespace App\Tests\BlackjackCardHand;

use PHPUnit\Framework\TestCase;

use App\Tests\BlackjackCardHand\TestModules\BlackjackCardHandCreateTest;
use App\Tests\BlackjackCardHand\TestModules\BlackjackCardHandGetAddTest;
use App\Tests\BlackjackCardHand\TestModules\BlackjackCardHandActiveTest;
use App\Tests\BlackjackCardHand\TestModules\BlackjackCardHandDrawUpdateTest;
use App\Tests\BlackjackCardHand\TestModules\BlackjackCardHandSplitTest;


/**
 * Test cases for the class BlackjackCardHand.
 */
class BlackjackCardHandTest extends TestCase
{
    use BlackjackCardHandCreateTest;
    use BlackjackCardHandGetAddTest;
    use BlackjackCardHandActiveTest;
    use BlackjackCardHandDrawUpdateTest;
    use BlackjackCardHandSplitTest;
}