<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\game\event;


use sergittos\skywars\utils\message\MessageContainer;

class DoomEvent extends Event {

    public function __construct() {
        parent::__construct("Doom", 2.5);
    }

    protected function end(): void {
        $this->game->broadcastTitle(new MessageContainer("SUDDEN_DEATH_TITLE"), null, 10, 60, 10);
    }

    public function getNextEvent(): ?Event {
        return new GameEndEvent();
    }

}