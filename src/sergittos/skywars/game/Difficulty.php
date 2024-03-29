<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\game;


enum Difficulty {

    case NORMAL;
    case INSANE;

    public function getDisplayName(): string {
        return match($this) {
            self::NORMAL => "Normal",
            self::INSANE => "Insane"
        };
    }

}