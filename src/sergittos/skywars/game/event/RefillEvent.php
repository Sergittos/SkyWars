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

class RefillEvent extends Event {

    private bool $repeat;

    public function __construct(bool $repeat = true) {
        $this->repeat = $repeat;
        parent::__construct("Refill", $repeat ? 3 : 2);
    }

    protected function end(): void {
        foreach($this->game->getOpenedChests() as $chest) {
            $chest->refill($this->game);
        }
        $this->game->broadcastTitle(new MessageContainer("CHESTS_REFILLED_TITLE"), null, 20, 60, 20);
    }

    public function getNextEvent(): ?Event {
        return $this->repeat ? new RefillEvent(false) : new DoomEvent();
    }

}