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
use sergittos\skywars\utils\ColorUtils;

class Session {

    private Player $player;

    public function __construct(Player $player) {
        $this->player = $player;
    }

    public function getPlayer(): Player {
        return $this->player;
    }

    public function getUsername(): string {
        return $this->player->getName();
    }

    public function message(string $message): void {
        $this->player->sendMessage(ColorUtils::translate($message));
    }

}