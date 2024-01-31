<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\session;


use pocketmine\player\Player;
use sergittos\skywars\game\Game;
use sergittos\skywars\game\team\Team;
use sergittos\skywars\utils\ColorUtils;

class Session {

    private Player $player;

    private ?Game $game = null;
    private ?Team $team = null;

    public function __construct(Player $player) {
        $this->player = $player;
    }

    public function getPlayer(): Player {
        return $this->player;
    }

    public function getUsername(): string {
        return $this->player->getName();
    }

    public function getGame(): ?Game {
        return $this->game;
    }

    public function getTeam(): ?Team {
        return $this->team;
    }

    public function hasGame(): bool {
        return $this->game !== null;
    }

    public function hasTeam(): bool {
        return $this->team !== null;
    }

    public function isPlaying(): bool {
        return $this->hasGame() and $this->game->isPlaying($this);
    }

    public function isSpectator(): bool {
        return $this->hasGame() and $this->game->isSpectator($this);
    }

    public function setGame(?Game $game): void {
        $this->game = $game;
    }

    public function setTeam(?Team $team): void {
        $this->team = $team;
    }

    public function clearInventories(): void {
        $this->player->getCursorInventory()->clearAll();
        $this->player->getOffHandInventory()->clearAll();
        $this->player->getArmorInventory()->clearAll();
        $this->player->getInventory()->clearAll();
    }

    public function message(string $message): void {
        $this->player->sendMessage(ColorUtils::translate($message));
    }

}