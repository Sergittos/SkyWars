<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\game\stage;


use pocketmine\player\GameMode;
use sergittos\skywars\game\event\Event;
use sergittos\skywars\game\event\RefillEvent;
use sergittos\skywars\session\scoreboard\layout\GameLayout;
use sergittos\skywars\session\Session;
use sergittos\skywars\utils\message\MessageContainer;

class PlayingStage extends Stage {

    private int $graceTime = 3;

    private ?Event $nextEvent = null;

    public function hasStarted(): bool {
        return $this->nextEvent !== null;
    }

    public function isGraceTimeOver(): bool {
        return $this->graceTime <= 0;
    }

    public function getNextEvent(): ?Event {
        return $this->nextEvent;
    }

    public function startNextEvent(?Event $event = null): void {
        $this->nextEvent = $event ?? $this->nextEvent->getNextEvent();
        $this->nextEvent?->start($this->game);
    }

    protected function onStart(): void {
        $this->game->broadcastMessage(new MessageContainer("CAGES_OPENED"));

        $this->startNextEvent(new RefillEvent());
    }

    public function onJoin(Session $session): void {
        $session->setScoreboardLayout(new GameLayout());
        $session->getSelectedKit()->apply($session);
        $session->getSelectedCage()->destroy($this->game->getWorld());
        $session->getPlayer()->setGamemode(GameMode::SURVIVAL);

        foreach($session->getSelectedChallenges() as $challenge) {
            $challenge->onGameStart($session);
        }
    }

    public function tick(): void {
        if($this->nextEvent->hasEnded()) {
            $this->startNextEvent();
        }

        if(!$this->isGraceTimeOver()) {
            $this->graceTime--;
        }

        foreach($this->game->getOpenedChests() as $chest) {
            $chest->updateFloatingText($this->game);
        }
        foreach($this->game->getPlayers() as $player) {
            $player->updateScoreboard();
        }
    }

}