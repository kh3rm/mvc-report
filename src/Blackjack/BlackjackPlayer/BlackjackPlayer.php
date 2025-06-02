<?php

namespace App\Blackjack\BlackjackPlayer;

use App\Blackjack\BlackjackCardHand\BlackjackCardHand;

/**
 * BlackjackPlayer-Class, for a player participating in a game of Blackjack.
 */
class BlackjackPlayer
{
    use BlackjackCardHandling;
    use BlackjackHandActionHandling;
    use ChipHandlingTrait;
    use TurnHandlingTrait;

    private bool $activeTurn;
    protected string $playerName;
    protected int $chips;
    protected int $chipsInPlay;

    /**
     * Constructor that takes two arguments at instantiation: a string of the
     * $playerName, and an an instance of BlackjackCardHand for the $hand.
     *
     * @param string $playerName
     * @param BlackjackCardHand[] $cardHands
     */
    public function __construct(string $playerName, array $cardHands, int $chips = 1000)
    {
        $this->addHands(...$cardHands);
        $this->playerName = $playerName;
        $this->chips = $chips;
        $this->activeTurn = true;
        $this->chipsInPlay = 0;
    }


    /**
     * Get the player name.
     */
    public function getPlayerName(): string
    {
        return $this->playerName;
    }


    /**
     * Gets the player details in JSON-formatting.
     *
     * @return array<string, mixed> a mixed array in JSON-friendly format.
     */
    public function getPlayerDetailsJson(): array
    {
        return [
            'playerName' => $this->playerName,
            'playerHandUnicode' => $this->getCardsInHandAsUnicode(),
            'chipsStatus' => "Chips: {$this->getChipCount()} (+{$this->getChipsInPlayCount()} in play)"
        ];
    }
}
