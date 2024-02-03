<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\session;


use sergittos\skywars\game\Difficulty;
use sergittos\skywars\game\kit\Kit;

class SessionKit {

    private Kit $kit;
    private Difficulty $difficulty;

    public function __construct(Kit $kit, Difficulty $difficulty) {
        $this->kit = $kit;
        $this->difficulty = $difficulty;
    }

    public function getKit(): Kit {
        return $this->kit;
    }

    public function getDifficulty(): Difficulty {
        return $this->difficulty;
    }

}