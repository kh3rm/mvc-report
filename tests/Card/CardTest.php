<?php

namespace App\Tests\Card;

use PHPUnit\Framework\TestCase;

use App\Tests\Card\TestModules\CardCreateTest;
use App\Tests\Card\TestModules\CardGetTest;

/**
 * Test cases for the class Card.
 */
class CardTest extends TestCase
{
    use CardCreateTest;
    use CardGetTest;
}