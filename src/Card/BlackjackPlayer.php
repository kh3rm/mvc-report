<?php

namespace App\Card;

use App\Exception\NotEnoughChipsException;

class BlackjackPlayer
{
    use BlackjackCardHandling;
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
     * Wager chips for the player by moving an amount from chips to chipsInPlay.
     * If no amount is specified, wagers a default amount of 100 times the number of hands.
     *
     * @param int|null $amount The amount of chips to wager. If null, defaults to 100 times the number of hands.
     *
     * @throws NotEnoughChipsException If the player does not have enough chips to wager the specified amount.
     */
    public function wagerChips(?int $amount = null): void
    {
        if ($amount === null) {
            $amount = $this->handsCount() * 100;
        }

        if ($this->chips < $amount) {
            throw new NotEnoughChipsException();
        }

        $this->chips -= $amount;
        $this->chipsInPlay += $amount;
    }

    /**
     * Add the chips awarded after round completion.
     */
    public function addChips(int $roundResultsChips): void
    {
        $this->chips = ($this->chips + $roundResultsChips);
    }

    /**
     * Get the chip-count.
     */
    public function getChipCount(): int
    {
        return $this->chips;
    }

    /**
     * Get the chips in play-count.
     */
    public function getChipsInPlayCount(): int
    {
        return $this->chipsInPlay;
    }

    /**
     * Resets the chips in play-count.
     */
    public function resetChipsInPlay(): void
    {
        $this->chipsInPlay = 0;
    }

    /**
     * Get the boolean-value of activeTurn.
     *
     * @return bool
     */
    public function isActiveTurn(): bool
    {
        return $this->activeTurn;
    }

    /**
     * Activate the player/dealer turn.
     */
    public function activateTurn(): void
    {
        $this->activeTurn = true;
    }

    /**
     * Dectivate the player/dealer turn.
     */
    public function deactivateTurn(): void
    {
        $this->activeTurn = false;
    }

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
