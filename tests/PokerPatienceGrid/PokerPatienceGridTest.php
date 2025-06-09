<?php

namespace App\Tests\PokerPatienceGrid;

use PHPUnit\Framework\TestCase;
use App\Tests\PokerPatienceGrid\TestModules\PokerPatienceGridCreateTest;
use App\Tests\PokerPatienceGrid\TestModules\PokerPatienceGridMiscTest;

class PokerPatienceGridTest extends TestCase
{
    use PokerPatienceGridCreateTest;
    use PokerPatienceGridMiscTest;

}