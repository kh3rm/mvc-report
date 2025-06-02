<?php

namespace App\Helper\BlackjackHelper;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Blackjack\BlackjackPlayer\BlackjackPlayer;
use App\Blackjack\BlackjackPlayer\BlackjackDealer;

/**
 * RoundWagerTrait
 */
trait RoundWagerTrait
{
    /**
     * prepareExecuteWagering()-method to calculate wagers and splits afforded
     * when initiating a new Blackjack-round.
     */
    private static function prepareExecuteWagering(
        BlackjackPlayer $player,
        BlackjackDealer $dealer,
        int $numberOfHands,
        SessionInterface $session
    ): void {
        $smallestChipCount = $session->get('smallest_chip_count') ?? $player->getChipCount();
        $nextRoundWager = (int)$numberOfHands * 100;
        $splitsAfforded = (($smallestChipCount - $nextRoundWager) / 100);

        self::roundWagers($player, $dealer, $nextRoundWager);

        $session->set("splits_afforded", $splitsAfforded);
    }

    /**
     * roundWagers()-method to handle Blackjack-round-wagering execution for the
     * player and dealer.
     */
    private static function roundWagers(
        BlackjackPlayer $player,
        BlackjackDealer $dealer,
        int $nextRoundWager
    ): void {
        $player->wagerChips($nextRoundWager);
        $dealer->wagerChips($nextRoundWager);
    }
}
