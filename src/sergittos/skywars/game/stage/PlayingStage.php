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
use sergittos\skywars\session\Session;

class PlayingStage extends Stage {

    public function onJoin(Session $session): void {
        $session->getSelectedKit()->apply($session);
        $session->getSelectedCage()->destroy($this->game->getWorld());

        $session->getPlayer()->setGamemode(GameMode::SURVIVAL);
    }

    public function tick(): void {
        foreach($this->game->getOpenedChests() as $chest) {
            $chest->attemptToRefill($this->game);
        }
    }

}