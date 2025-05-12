<?php

namespace App\Helper;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Helper
{
    public function clearBlackjackGameSession(SessionInterface $session): void
    {
        $session->remove("deck_in_use");
        $session->remove("player");
        $session->remove("dealer");
        $session->remove("splits_afforded");
        $session->remove("roundmsg");
        $session->remove("game_decided");
        $session->remove("smallest_chip_count");
        $session->remove("maximum_hands");
        $session->remove("game-finished-object");
        $session->remove("current_chip_count");
        $session->remove("current_chip_count_json");
    }
}
