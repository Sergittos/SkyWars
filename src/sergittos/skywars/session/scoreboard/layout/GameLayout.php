<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\session\scoreboard\layout;


use sergittos\skywars\session\Session;
use sergittos\skywars\utils\message\MessageContainer;
use function date;
use function gmdate;

class GameLayout implements Layout {

    public function getMessageContainer(Session $session): MessageContainer {
        $game = $session->getGame();
        $event = $game->getStage()->getNextEvent();

        return new MessageContainer("GAME_SCOREBOARD", [
            "date" => date("m/d/y"),
            "event" => $event->getName(),
            "time" => gmdate("i:s", $event->getTimeRemaining()),
            "players_count" => $game->getPlayersCount(),
            "kills" => $session->getStatistics()->getKills(null),
            "map" => $game->getMap()->getName(),
            "mode" => $game->getDifficulty()->getDisplayName(),
        ]);
    }

}