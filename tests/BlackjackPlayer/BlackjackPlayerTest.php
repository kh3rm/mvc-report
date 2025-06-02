<?php

namespace App\Tests\BlackjackPlayer;

use PHPUnit\Framework\TestCase;

use App\Tests\BlackjackPlayer\TestModules\BlackjackPlayerCreateTest;
use App\Tests\BlackjackPlayer\TestModules\BlackjackPlayerTurnTest;
use App\Tests\BlackjackPlayer\TestModules\BlackjackPlayerChipTest;
use App\Tests\BlackjackPlayer\TestModules\BlackjackPlayerJsonTest;

class BlackjackPlayerTest extends TestCase
{
    use BlackjackPlayerCreateTest;
    use BlackjackPlayerTurnTest;
    use BlackjackPlayerChipTest;
    use BlackjackPlayerJsonTest;
}
