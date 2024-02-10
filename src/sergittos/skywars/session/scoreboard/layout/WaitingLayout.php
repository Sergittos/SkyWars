<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\session\scoreboard\layout;


use sergittos\skywars\game\stage\StartingStage;
use sergittos\skywars\session\Session;
use sergittos\skywars\utils\message\MessageContainer;

class WaitingLayout implements Layout {

    public function getMessageContainer(Session $session): MessageContainer {
        $game = $session->getGame();
        $map = $game->getMap();
        $stage = $game->getStage();

        return new MessageContainer("WAITING_SCOREBOARD", [
            "date" => date("m/d/y"),
            "players_count" => $game->getPlayersCount(),
            "slots" => $map->getSlots(),
            "stage" => !$stage instanceof StartingStage ? new MessageContainer("WAITING_STAGE") : new MessageContainer("STARTING_STAGE", ["time" => $stage->getCountdown()]),
            "map" => $map->getName(),
            "mode" => $game->getDifficulty()->getDisplayName(),
        ]);
    }

}