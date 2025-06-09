<?php namespace App\Tests\PokerPatienceGrid\TestModules;

use App\PokerPatienceGS\PokerPatienceGrid;

trait PokerPatienceGridMiscTest {
    /**
     * Ascertain that the method addCardToGrid() works correctly when adding
     *  a card to a valid index.
     */
    public function testAddCardToGridValidIndex() {
        $grid = new PokerPatienceGrid();
        $result = $grid->addCardToGrid(114, 0);
        $this->assertTrue($result);
        $this->assertEquals(114, $grid->getGrid()[0]);
    }

    /**
     * Verify that the addCardToGrid()-method  fails when trying to add  a card
     * to an invalid index.
     */
    public function testAddCardToGridInvalidIndex() {
        $grid = new PokerPatienceGrid();
        $result = $grid->addCardToGrid(114, 30);
        $this->assertFalse($result);
    }



    /**
     * Verify that the addCardToGrid()-method fails when trying to add a
     *  card with a negative index.
     */
    public function testAddCardToGridInvalidCardNegativeValue() {
        $grid = new PokerPatienceGrid();
        $result = $grid->addCardToGrid(114, -1);
        $this->assertFalse($result);
    }

    /**
     * Verify that the addCardToGrid()-method  fails when trying to add to an already occupied index.
     */
    public function testAddCardToGridOccupiedIndex() {
        $grid = new PokerPatienceGrid();
        $grid->addCardToGrid(114, 0);
        $result = $grid->addCardToGrid(214, 0);
        $this->assertFalse($result);
        $this->assertEquals(114, $grid->getGrid()[0]);
    }

    /**
     * Verify that the clearGrid()-method resets the grid back to its initial empty state.
     */
    public function testClearGrid() {
        $grid = new PokerPatienceGrid();
        $grid->addCardToGrid(114, 0);
        $grid->clearGrid();
        $this->assertEquals(array_fill(0, 25, null), $grid->getGrid());
    }


    /**
     * Verify that the clearGrid()-method does not fail if called on an already empty grid.
     */
    public function testClearGridOnEmptyGrid() {
        $grid = new PokerPatienceGrid();
        $initialGridState = $grid->getGrid();
        $grid->clearGrid();
        $this->assertEquals($initialGridState, $grid->getGrid());
    }




    /**
     * Verify that the establishEmptyScores()-method returns the correct initial score structure.
     */
    public function testEstablishEmptyScores() {
        $grid = new PokerPatienceGrid();
        $result = $grid->establishEmptyScores();

        $this->assertIsArray($result);

        $expectedStructure = [
            "horizontal" => [0,0,0,0,0],
            "vertical" => [0,0,0,0,0],
            "current_score" => 0
        ];

        $this->assertEquals($result, $expectedStructure);

    }
}


