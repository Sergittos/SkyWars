<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\session\scoreboard;


use function date;

class GameScoreboard extends Scoreboard {

    protected function getLines(): array {
        $game = $this->session->getGame();
        return [
            13 => "{GRAY}" . date("m/d/y"),
            12 => "    ",
            11 => "{WHITE}Next Event:",
            10 => "{GREEN}Refill 2:58",
            9 => "     ",
            8 => "{WHITE}Players left: {GREEN}" . $game->getPlayersCount(),
            7 => "      ",
            6 => "{WHITE}Kills: {GREEN}0",
            5 => "       ",
            4 => "{WHITE}Map: {GREEN}" . $game->getMap()->getName(),
            3 => "{WHITE}Mode: {GREEN}" . $game->getDifficulty()->getDisplayName()
        ];
    }

}