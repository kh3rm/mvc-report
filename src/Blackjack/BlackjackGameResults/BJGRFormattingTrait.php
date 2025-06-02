<?php

namespace App\Blackjack\BlackjackGameResults;

use App\Blackjack\BlackjackPlayer\BlackjackPlayer;
use App\Blackjack\BlackjackPlayer\BlackjackDealer;

/**
 * BJGRFormattingTrait, containing all the results formatting-related logic
 * relating to the BlackjackGameResults-class.
 */
trait BJGRFormattingTrait
{
    /**
     * Formats the round results into an array structure for output.
     *
     * @param BlackjackPlayer $player The player whose results are formatted.
     * @param BlackjackDealer $dealer The dealer.
     * @param int $playerWon The total chips won by the player.
     * @param int $dealerWon The total chips won by the dealer.
     * @param int $totalWagered The total amount wagered in the round.
     * @return mixed[] An array with round result strings and JSON-formatted chip counts.
     */
    private function formatRoundResults($player, $dealer, $playerWon, $dealerWon, $totalWagered): array
    {
        $playerName = $player->getPlayerName();
        $playerResults = $playerWon - ($totalWagered / 2);
        $dealerResults = $dealerWon - ($totalWagered / 2);

        return [
            "round-results" => "Round Results: $playerName: " . $this->formatResult($playerResults) .
                            ", Dealer: " . $this->formatResult($dealerResults) . ".",
            "chip-count" => "$playerName: " . $player->getChipCount() .
                            " Dealer: " . $dealer->getChipCount(),
            "chip-count-json" => [
                "$playerName" => $player->getChipCount(),
                "dealer" => $dealer->getChipCount(),
            ]
        ];
    }

    /**
     * Formats the results for display.
     *
     * @param int $results The results amount to format.
     * @return string Formatted result as a string with an initial '+' for the positive results.
     */
    private function formatResult($results): string
    {
        return ($results >= 0 ? '+' : '') . $results;
    }
}
