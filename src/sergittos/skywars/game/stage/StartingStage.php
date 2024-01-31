<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\game\stage;


use sergittos\skywars\game\stage\trait\JoinableTrait;
use sergittos\skywars\session\Session;

class StartingStage extends Stage {
    use JoinableTrait {
        onQuit as onSessionQuit;
    }

    private int $countdown = 10;

    public function getCountdown(): int {
        return $this->countdown;
    }

    public function onQuit(Session $session): void {
        $this->onSessionQuit($session);
        $this->stopIfNotReady();
    }

    public function tick(): void {
        if($this->countdown <= 0) {
            $this->game->setStage(new PlayingStage());
        }

        $this->countdown--;
    }

    private function stopIfNotReady(): void {
        // todo
    }

}