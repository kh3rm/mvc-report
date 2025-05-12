<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\CardGraphic;
use App\Card\CardHand;
use App\Card\DeckOfCards;
use App\Card\DeckOfCards52;
use App\Card\Player;
use App\Card\BlackjackPlayer;
use App\Card\BlackjackDealer;
use App\Card\BlackjackCardHand;
use App\Card\BlackjackGameResults;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlackjackGameControllerTwig extends AbstractController
{
    #[Route("/game/init", name: "blackjack_init_post", methods: ['POST'])]
    public function initCallback(
        Request $request,
        SessionInterface $session
    ): Response {

        $playerName = trim((string) $request->request->get('player_name', ''));
        if (empty($playerName)) {
            $this->addFlash('warning', 'Sorry, you need to provide a valid player name.');
            return $this->redirectToRoute('game_init_get');
        }


        $startingChips = (int) $request->request->get('starting_chips', 1000);
        $numberOfHands = (int) $request->request->get('number_of_hands', 1);


        if ($startingChips <= 0 || $numberOfHands <= 0) {
            $this->addFlash('warning', 'Sorry, the starting chips and number of hands must be positive integers.');
            return $this->redirectToRoute('game_init_get');
        }

        if (($numberOfHands * 100) > $startingChips) {
            $this->addFlash('warning', 'Sorry, the number of hands can maximally be the starting chips / 100.');
            return $this->redirectToRoute('game_init_get');
        }

        $chipsInPlay = (int)$numberOfHands * 100;
        $remainingChips = (int)$startingChips - $chipsInPlay;
        $splitsAfforded = $remainingChips / 100;


        $deckInUse = new DeckOfCards52();
        $deckInUse->shuffleDeckOfCards();

        $playerHands = [];
        for ($i = 0; $i < $numberOfHands; $i++) {
            $cards = $deckInUse->drawCards(2) ?? [];
            $playerHands[] = new BlackjackCardHand($cards);
        }


        $dealerCards = $deckInUse->drawCards(2) ?? [];
        $dealerHand = new BlackjackCardHand($dealerCards);

        $player = new BlackjackPlayer($playerName, $playerHands, (int)$startingChips);
        $dealer = new BlackjackDealer([$dealerHand], (int)$startingChips);

        $player->wagerChips();
        $playerChipsInPlay = $player->getChipsInPlayCount();
        $dealer->WagerChips($playerChipsInPlay);


        $session->set("deck_in_use", $deckInUse);
        $session->set("player", $player);
        $session->set("dealer", $dealer);
        $session->set("splits_afforded", $splitsAfforded);

        return $this->redirectToRoute('blackjack_play');
    }

    #[Route("/game/play", name: "blackjack_play", methods: ['GET'])]
    public function play(
        SessionInterface $session
    ): Response {

        $player = $session->get("player");
        $player->updateHandsStatus();
        $player->activeTurnStatus();

        $dealer = $session->get("dealer");

        if (!$player->isActiveTurn()) {
            $dealer->activateTurn();
        }


        $session->set("player", $player);
        $session->set("dealer", $dealer);


        $data = [
            "player" => $player,
            "dealer" => $dealer,
            "deck" => $session->get("deck_in_use"),
            "splits_afforded" => $session->get("splits_afforded")
        ];

        return $this->render('game/play.html.twig', $data);
    }

    #[Route("/game/round-complete", name: "round_finished", methods: ['GET'])]
    public function roundFinished(
        SessionInterface $session
    ): Response {

        $player = $session->get("player");
        $dealer = $session->get("dealer");
        $gameResults = $session->get("game-finished-object");



        $data = [
            "player" => $player,
            "dealer" => $dealer,
            "deck" => $session->get('deck_in_use'),
            "roundmsg" => $session->get('roundmsg'),
            "chipcount" => $session->get('current_chip_count'),
            "game_decided" => $session->get('game_decided')
        ];

        if ($gameResults) {
            $gameResults->establishUpToDateSession($session);
            $gameResults->clearBlackjackGameSession();
        }




        return $this->render('game/round-results.html.twig', $data);
    }


    #[Route("/game/hit-hand", name: "game_hit", methods: ['POST'])]
    public function hitHand(SessionInterface $session, Request $request): Response
    {

        $handIndex = $request->request->get('handIndex');

        $player = $session->get('player');
        $deckInUse = $session->get('deck_in_use');
        $cardToBeAdded = $deckInUse->drawCard();
        $player->addCardToHand($handIndex, $cardToBeAdded);

        $session->set('deck_in_use', $deckInUse);
        $session->set('player', $player);

        return $this->redirectToRoute('blackjack_play');
    }

    #[Route("/game/stand-hand", name: "stand-hand", methods: ['POST'])]
    public function standHand(SessionInterface $session, Request $request): Response
    {

        $handIndex = $request->request->get('handIndex');

        $player = $session->get('player');
        $player->standHand($handIndex);
        $session->set('player', $player);

        return $this->redirectToRoute('blackjack_play');
    }


    #[Route("/game/split-hand", name: "split-hand", methods: ['POST'])]
    public function splitHand(SessionInterface $session, Request $request): Response
    {

        $handIndex = $request->request->get('handIndex');

        $player = $session->get('player');
        $dealer = $session->get('dealer');
        $deckInUse = $session->get('deck_in_use');
        $player->splitHand($handIndex, $deckInUse);

        $player->wagerChips(100);
        $dealer->wagerChips(100);


        $splitsAfforded = $session->get('splits_afforded');

        $session->set('player', $player);
        $session->set('dealer', $dealer);
        $session->set('deck_in_use', $deckInUse);
        $session->set("splits_afforded", ($splitsAfforded - 1));

        return $this->redirectToRoute('blackjack_play');
    }

    #[Route("/game/dealer-hit", name: "dealer-hit", methods: ['POST'])]
    public function dealerHit(SessionInterface $session): Response
    {

        $dealer = $session->get('dealer');
        $deckInUse = $session->get('deck_in_use');
        $dealer->getHands()[0]->drawCardFromDeck($deckInUse);

        $session->set('dealer', $dealer);
        $session->set('deck_in_use', $deckInUse);

        return $this->redirectToRoute('blackjack_play');
    }


    #[Route("/game/round-complete", name: "round-complete", methods: ['POST'])]
    public function roundComplete(SessionInterface $session): Response
    {

        $player = $session->get('player');
        $dealer = $session->get('dealer');

        $blackjackGameResults = new BlackjackGameResults($player, $dealer);

        $gameResultArray = $blackjackGameResults->decideBlackjackRoundResults();
        $gameDecided = $blackjackGameResults->getGameDecided();

        $session->set('player', $player);
        $session->set('dealer', $dealer);
        $session->set('roundmsg', $gameResultArray['round-results']);
        $session->set('current_chip_count', $gameResultArray['chip-count']);
        $session->set('current_chip_count_json', $gameResultArray['chip-count-json']);
        $session->set('game_decided', $gameDecided);

        if ($gameDecided) {
            $session->set('game-finished-object', $blackjackGameResults);
        }

        return $this->redirectToRoute('round_finished');
    }


    #[Route("/game/next-round", name: "next-round", methods: ['POST'])]
    public function nextRound(SessionInterface $session): Response
    {

        $player = $session->get('player');
        $dealer = $session->get('dealer');
        $deckInUse = $session->get('deck_in_use');

        $gameDecided = $session->get('game_decided');

        $playerChipCount = $player->getChipCount();
        $dealerChipCount = $dealer->getChipCount();

        $smallestChipCount = min($playerChipCount, $dealerChipCount);

        $session->set('smallest_chip_count', $smallestChipCount);


        $maximumHands = $smallestChipCount / 100;

        $session->set('maximum_hands', $maximumHands);

        $data = [
            "player" => $player,
            "dealer" => $dealer,
            "deck" => $deckInUse,
            "maximum_hands" => $maximumHands,
            "game_decided" => $gameDecided
        ];

        return $this->render('game/next-round-init.html.twig', $data);
    }



    #[Route("/game/next-round-init", name: "next_round_init", methods: ['POST'])]
    public function nextRoundInit(
        Request $request,
        SessionInterface $session
    ): Response {
        $numberOfHands = $request->request->get('number_of_hands', 1);

        $player = $session->get('player');
        $dealer = $session->get('dealer');

        $deckInUse = new DeckOfCards52();
        $deckInUse->shuffleDeckOfCards();

        $playerHands = [];
        for ($i = 0; $i < $numberOfHands; $i++) {
            $cards = $deckInUse->drawCards(2) ?? [];
            $playerHands[] = new BlackjackCardHand($cards);
        }

        $dealerCards = $deckInUse->drawCards(2) ?? [];
        $dealerHand = new BlackjackCardHand($dealerCards);

        $player->addHands(...$playerHands);
        $dealer->addHands($dealerHand);

        $smallestChipCount = $session->get('smallest_chip_count');

        $nextRoundWager = (int)$numberOfHands * 100;

        $splitsAfforded = ((int)$smallestChipCount - $nextRoundWager) / 100;

        $session->set("splits_afforded", $splitsAfforded);

        if ($player instanceof BlackjackPlayer && $dealer instanceof BlackjackDealer) {
            $player->wagerChips($nextRoundWager);
            $dealer->wagerChips($nextRoundWager);
        }

        $session->set("deck_in_use", $deckInUse);
        $session->set("player", $player);
        $session->set("dealer", $dealer);

        return $this->redirectToRoute('blackjack_play');
    }

}
