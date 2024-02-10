<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\game\event;


use sergittos\skywars\game\stage\EndingStage;

class GameEndEvent extends Event {

    public function __construct() {
        parent::__construct("Game End", 1.5);
    }

    protected function end(): void {
        $this->game->setStage(new EndingStage());
    }

    public function getNextEvent(): ?Event {
        return null;
    }

}