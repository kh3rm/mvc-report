<?php

namespace App\Tests\BlackjackCardHandling;

use PHPUnit\Framework\TestCase;

use App\Tests\BlackjackCardHandling\TestModules\BJCardHandlingGetAddHandTest;
use App\Tests\BlackjackCardHandling\TestModules\BJCardHandlingHandStatusTest;
use App\Tests\BlackjackCardHandling\TestModules\BJCardHandlingSplitHandTest;
use App\Tests\BlackjackCardHandling\TestModules\BJCardHandlingStandHandTest;
use App\Tests\BlackjackCardHandling\TestModules\BJCardHandlingTurnStatusResetTest;
use App\Tests\BlackjackCardHandling\TestModules\BJCardHandlingUnicodeTest;


class BlackjackCardHandlingTest extends TestCase {

    use BJCardHandlingGetAddHandTest;
    use BJCardHandlingHandStatusTest;
    use BJCardHandlingSplitHandTest;
    use BJCardHandlingStandHandTest;
    use BJCardHandlingTurnStatusResetTest;
    use BJCardHandlingUnicodeTest;
};