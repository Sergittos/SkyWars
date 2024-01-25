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

class WaitingStage extends Stage {
    use JoinableTrait {
        onJoin as onSessionJoin;
    }

    public function onJoin(Session $session): void {
        $this->onSessionJoin($session);
        $this->startIfReady();
    }

    private function startIfReady(): void {
        // todo
    }

    public function tick(): void {}

}