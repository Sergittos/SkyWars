<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\session\scoreboard;


use sergittos\skywars\game\stage\StartingStage;
use function date;

class WaitingScoreboard extends Scoreboard {

    protected function getLines(): array {
        $game = $this->session->getGame();
        $map = $game->getMap();
        $stage = $game->getStage();
        return [
            10 => "{GRAY}" . date("m/d/y"),
            9 => "    ",
            8 => "{WHITE}Players: {GREEN}" . $game->getPlayersCount() . "/" . $map->getSlots(),
            7 => "     ",
            6 => !$stage instanceof StartingStage ? "{WHITE}Waiting..." : "{WHITE}Starting in {GREEN}" . $stage->getCountdown() . "s",
            5 => "      ",
            4 => "{WHITE}Map: {GREEN}" . $map->getName(),
            3 => "{WHITE}Mode: {GREEN}" . $game->getDifficulty()->getDisplayName()
        ];
    }

}