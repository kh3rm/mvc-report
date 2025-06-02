<?php

namespace App\Blackjack\BlackjackGameResults;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * BJGRSessionHandlingTrait, containing all the session-related logic
 * relating to the BlackjackGameResults-class.
 */
trait BJGRSessionHandlingTrait
{
    /**
     * Establishing the current session-state to enable the session-clearing method to do its job.
     * (In accordance with the principle of dependency injection.)
     */
    public function establishUpToDateSession(SessionInterface $session): void
    {
        $this->sessionState = $session;
    }

    /**
     * Get the object's sessionState.
     */
    public function getSessionState(): ?SessionInterface
    {
        return $this->sessionState;
    }


    /**
     * Clear the BlackjackGame-related session-data.
     */
    public function clearBlackjackGameSession(): void
    {

        if ($this->sessionState instanceof SessionInterface) {
            $this->sessionState->remove("deck_in_use");
            $this->sessionState->remove("player");
            $this->sessionState->remove("dealer");
            $this->sessionState->remove("splits_afforded");
            $this->sessionState->remove("roundmsg");
            $this->sessionState->remove("game_decided");
            $this->sessionState->remove("smallest_chip_count");
            $this->sessionState->remove("maximum_hands");
            $this->sessionState->remove("game-finished-object");
            $this->sessionState->remove("current_chip_count");
            $this->sessionState->remove("current_chip_count_json");
        }
    }

}
