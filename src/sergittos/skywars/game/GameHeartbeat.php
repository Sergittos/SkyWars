<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\game;


use pocketmine\scheduler\Task;
use sergittos\skywars\SkyWars;

class GameHeartbeat extends Task {

    public function onRun(): void {
        foreach(SkyWars::getInstance()->getGameManager()->getGames() as $game) {
            $game->getStage()->tick();
        }
    }

}