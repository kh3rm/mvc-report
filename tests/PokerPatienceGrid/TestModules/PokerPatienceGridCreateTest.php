<?php namespace App\Tests\PokerPatienceGrid\TestModules;

use App\PokerPatienceGS\PokerPatienceGrid;

trait PokerPatienceGridCreateTest {
    /**
     * Construct object and verify that it initializes correctly.
     */
    public function testCreatePokerPatienceGrid() {
        $grid = new PokerPatienceGrid();
        $this->assertInstanceOf(PokerPatienceGrid::class, $grid);
        $this->assertNotEmpty($grid);
    }


    /**
     * Construct object and verify that it is an array with 25 values.
     */
    public function testCreatePokerPatienceGridCount() {
        $grid = new PokerPatienceGrid();
        $this->assertCount(25, $grid->getGrid());
        $this->assertEquals(array_fill(0, 25, null), $grid->getGrid());
    }


    /**
     * Construct object and validate that the grid cannot be set to a non-25-entry array.
     */
    public function testSetGridInvalidSize() {
        $grid = new PokerPatienceGrid();
        $result = $grid->setGrid(array_fill(0, 24, 0));
        $this->assertFalse($result);
        $this->assertEquals(array_fill(0, 25, null), $grid->getGrid());
    }

    /**
     * Construct object and validate that the grid can be set with a valid 25-entry array.
     */
    public function testSetGridValidSize() {
        $grid = new PokerPatienceGrid();
        $newGrid = array_fill(0, 25, 0);
        $result = $grid->setGrid($newGrid);
        $this->assertTrue($result);
        $this->assertEquals($newGrid, $grid->getGrid());
    }
}
