<?php

namespace App\Card;
use App\Exception\HandOutOfBoundsException;
use App\Exception\NotEnoughChipsException;
use App\Exception\InvalidCardHandException;

class BlackjackPlayer
{
    private bool $activeTurn;
    protected string $playerName;
    protected array $hands;
    protected int $chips;
    protected int $chipsInPlay;
    private int $handCount;

    /**
     * Constructor that takes two arguments at instantiation: a string of the
     * $playerName, and an an instance of BlackjackCardHand for the $hand.
     *
     * @param string $playerName
     * @param BlackjackCardHand[] $cardHands
     */
    public function __construct(string $playerName, array $cardHands, int $chips = 1000)
    {
        $this->hands = $cardHands;
        $this->playerName = $playerName;
        $this->chips = $chips;
        $this->activeTurn = true;
        $this->handCount = count($cardHands);
        $this->chipsInPlay = 0;
    }

    public function getHands(): array
    {
        return $this->hands;
    }

    public function resetHands(): void
    {
        $this->hands = [];
        $this->handCount = 0;
    }



    /**
     * Adds a new hand for the player/dealer (used for example when splitting).
     *
     * @param BlackjackCardHand $newHand
     * @throws InvalidCardHandException if the provided newHand is not an instande of BlackjackCardHand.
     */
    public function addHand(BlackjackCardHand $newHand): void
    {
        if (!$newHand instanceof BlackjackCardHand) {
            throw new InvalidCardHandException();
        }

        $this->hands[] = $newHand;
        $this->handCount++;
    }

    /**
     * Adds new hands using addHand().
     *
     * @param array $newHands An array of BlackjackCardHand objects to be added.
     * @throws InvalidCardHandException if any item in $newHands is not a BlackjackCardHand.
     */
    public function addHands(array $newHands): void
    {
        foreach ($newHands as $newHand) {
            $this->addHand($newHand);
        }
    }

    public function addCardToHand(int $handIndex, Card $card): void
    {
        if ($handIndex < 0 || $handIndex >= $this->handCount) {
            throw new HandOutOfBoundsException();
        }

        $this->hands[$handIndex]->addCard($card);
    }


    public function standHand(int $handIndex): void
    {
        if ($handIndex < 0 || $handIndex >= $this->handCount) {
            throw new HandOutOfBoundsException();
        }

        $this->hands[$handIndex]->setHandInactive();
    }


    public function splitHand(int $handIndex, $deck): void
    {
        if ($handIndex < 0 || $handIndex >= $this->handCount) {
            throw new HandOutOfBoundsException();
        }

        $handToSplit = $this->hands[$handIndex];

        $splittedHands = $handToSplit->splitHand($deck);

        array_splice($this->hands, $handIndex, 1, $splittedHands);
        $this->handCount = count($this->hands);
    }



    /**
     * Checks if all of the player's hands are inactive, and if so, updates the activeTurn attribute
     * accordingly.
     */
    public function activeTurnStatus(): void
    {
        $noHandsActive = true;

        foreach ($this->hands as $hand) {
            if ($hand->isHandActive()) {
                $noHandsActive = false;
                break;
            }
        }

        $this->activeTurn = !$noHandsActive;
    }



    /**
     * Loops through all of the player's hands and updates their statuses.
     */
    public function updateHandsStatus(): void
    {
        foreach ($this->hands as $hand) {
            $hand->updateHandStatus();
        }
    }





    /**
     * Returns the count of active hands for the player.
     *
     * @return int The number of active hands.
     */
    public function activeHandsCount(): int
    {
        $activeCount = 0;

        foreach ($this->hands as $hand) {
            if ($hand->isHandActive()) {
                $activeCount++;
            }
        }

        return $activeCount;
    }


    /**
     * Returns the number of hands (handCount).
     *
     * @return int The number of hands.
     */
    public function handsCount(): int
    {
        return $this->handCount;
    }


    /**
     * Wager 100 x the number of hands in $hands, and move that amount from chips
     * to chipsInPlay (in limbo, awaiting round resolution).
     *
     * @throws NotEnoughChipsException If the player does not have enough chips to wager.
     */
    public function wagerChips(): void
    {

        $wagerAmount = $this->handsCount() * 100;

        if ($this->chips < $wagerAmount) {
            throw new NotEnoughChipsException();
        }

        $this->chips -= $wagerAmount;
        $this->chipsInPlay += $wagerAmount;
    }


    /**
     * Wager the amount given, and move that amount from chips
     * to chipsInPlay (in limbo, awaiting round resolution).
     *
     */
    public function wagerChipsSimple($wagerAmount): void
    {

        $this->chips -= $wagerAmount;
        $this->chipsInPlay += $wagerAmount;
    }





    /**
     * Add the chips awarded after round completion.
     *
     */
    public function addChips(int $roundResultsChips): void
    {
        $this->chips = ($this->chips + $roundResultsChips);
    }


    /**
     * Get the chip-count.
     *
     */
    public function getChipCount(): int
    {
        return $this->chips;
    }


    /**
     * Get the chip-count.
     *
     */
    public function isOutOfChips(): int
    {
        return $this->chips;
    }


    /**
     * Get the chips in play-count.
     *
     */
    public function getChipsInPlayCount(): int
    {
        return $this->chipsInPlay;
    }



    /**
     * Resets the chips in play-count.
     *
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

    public function getCardsInHandAsUnicode(): string
{
    $unicodeHands = [];

    foreach ($this->hands as $hand) {
        $unicodeHands[] = $hand->getCardsAsUnicode();
    }

    return implode(", ", $unicodeHands);
}

    /**
    * Method that returns the name of the player and the cards in hand in Unicode-representation,
    * in an associative array, in JSON-friendly-formatting, primarily for JSON-routes.
    *
    * @return array<string,string> An associative array where:
    * - 'playerName' is the player's name (string)
    * - 'playerHandUnicode' is the cards in hand(s) as Unicode (string)
    */
    public function getNameAndHandUnicodeJson(): array
    {
        return [
            'playerName' => $this->playerName,
            'playerHandUnicode' => $this->getCardsInHandAsUnicode(),
        ];
}
}
