<?php

namespace App\Tests\DeckOfCards;

use PHPUnit\Framework\TestCase;

use App\Tests\DeckOfCards\TestModules\DeckOfCardsCreateTest;
use App\Tests\DeckOfCards\TestModules\DeckOfCardsDrawAddTest;
use App\Tests\DeckOfCards\TestModules\DeckOfCardsSortShuffleTest;
use App\Tests\DeckOfCards\TestModules\DeckOfCardsUnicodeTest;

/**
 * Test-class for the class DeckOfCards.
 */
class DeckOfCardsTest extends TestCase
{
    use DeckOfCardsCreateTest;
    use DeckOfCardsDrawAddTest;
    use DeckOfCardsSortShuffleTest;
    use DeckOfCardsUnicodeTest;
}
