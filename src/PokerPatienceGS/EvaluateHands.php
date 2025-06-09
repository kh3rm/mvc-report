<?php namespace App\PokerPatienceGS;
use App\Exception\IncorrectGridFormatException;

/**
 * Class EvaluateHands
 *
 * This class evaluates poker hands from a 5x5 grid representing a game state.
 */
class EvaluateHands {
    private $grid;

    use HandScoringTrait;
    use HandEvaluationTrait;

    /**
     * EvaluateHands constructor.
     *
     * @param array $gameStateGrid An array representing the game state grid.
     * @throws IncorrectGridFormatException If the grid does not contain exactly 25 values.
     */
    public function __construct(array $gameStateGrid) {
        if (count($gameStateGrid) !== 25) {
            throw new IncorrectGridFormatException;
        }
        $this->grid = $gameStateGrid;
    }


    /**
     * Evaluates the grid and returns scores for horizontal and vertical hands.
     *
     * @return array A JSON-ready associative array containing the scores
     * for horizontal and vertical hands and the current score.
     */
    public function evaluate(): array {
        $horizontalHands = $this->getHorizontalHands();
        $verticalHands = $this->getVerticalHands();

        $horizontalScores = $this->evaluateHands($horizontalHands);
        $verticalScores = $this->evaluateHands($verticalHands);

        $combinedScores = array_sum($horizontalScores) + array_sum($verticalScores);

        return [
            'horizontal' => $horizontalScores,
            'vertical' => $verticalScores,
            'current_score' => $combinedScores
        ];
    }




    /**
     * Gets the 5 horizontal hands from the grid.
     *
     * @return array An array containing all horizontal hands.
     */
    private function getHorizontalHands(): array {
        $horizontalHands = [];

        for ($currentRow = 0; $currentRow < 5; $currentRow++) {
            $startingIndex = $currentRow * 5;

            $horizontalRowHand = array_slice($this->grid, $startingIndex, 5);
            $horizontalHands[] = $horizontalRowHand;
        }

        return $horizontalHands;
    }

    /**
     * Gets the 5 vertical hands from the grid.
     *
     * @return array An array containing all vertical hands.
     */
    private function getVerticalHands(): array {
        $verticalHands = [];

        for ($columnIndex = 0; $columnIndex < 5; $columnIndex++) {
            $verticalColumnHand = [];

            for ($rowIndex = 0; $rowIndex < 5; $rowIndex++) {
                $gridIndex = $rowIndex * 5 + $columnIndex;
                $verticalColumnHand[] = $this->grid[$gridIndex];
            }

            $verticalHands[] = $verticalColumnHand;
        }

        return $verticalHands;
    }

}
