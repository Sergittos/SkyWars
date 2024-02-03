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

class LobbyScoreboard extends Scoreboard {

    protected function getLines(): array {
        return [
            12 => "{GRAY}" . date("m/d/y"),
            11 => "    ",
            10 => "{WHITE}Solo Kills: {GREEN}148",
            9 => "{WHITE}Solo Wins: {GREEN}14",
            8 => "{WHITE}Doubles Kills: {GREEN}177",
            7 => "{WHITE}Doubles Wins: {GREEN}19",
            6 => "     ",
            5 => "{WHITE}Coins: {GOLD}229.584",
            4 => "{WHITE}Souls: {AQUA}25{GRAY}/100",
            3 => "{WHITE}Tokens: {DARK_GREEN}32.000",
        ];
    }

}