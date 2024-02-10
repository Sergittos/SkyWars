<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\session\scoreboard\layout;


use sergittos\skywars\game\map\Mode;
use sergittos\skywars\session\Session;
use sergittos\skywars\utils\message\MessageContainer;
use function date;

class LobbyLayout implements Layout {

    public function getMessageContainer(Session $session): MessageContainer {
        $statistics = $session->getStatistics();

        return new MessageContainer("LOBBY_SCOREBOARD", [
            "date" => date("m/d/y"),
            "solo_kills" => $statistics->getKills(Mode::SOLOS),
            "solo_wins" => $statistics->getWins(Mode::SOLOS),
            "doubles_kills" => $statistics->getKills(Mode::DUOS),
            "doubles_wins" => $statistics->getWins(Mode::DUOS),
            "coins" => $statistics->getCoins(),
            "souls" => $statistics->getSouls(),
            "tokens" => $statistics->getTokens(),
        ]);
    }

}