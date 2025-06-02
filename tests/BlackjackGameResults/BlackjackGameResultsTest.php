<?php

namespace App\Tests\BlackjackGameResults;

use PHPUnit\Framework\TestCase;

use App\Tests\BlackjackGameResults\TestModules\BJGGRCreateDecidedTest;
use App\Tests\BlackjackGameResults\TestModules\BJGGRSessionTest;
use App\Tests\BlackjackGameResults\TestModules\BJGGRRoundTest;


class BlackjackGameResultsTest extends TestCase
{
    use BJGGRCreateDecidedTest;
    use BJGGRSessionTest;
    use BJGGRRoundTest;
}
