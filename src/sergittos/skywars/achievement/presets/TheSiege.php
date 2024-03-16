<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\achievement\presets;


use sergittos\skywars\achievement\Achievement;

class TheSiege extends Achievement {

    public function __construct() {
        parent::__construct("The siege", "Get the final kill of a game in your spawn island", 10);
    }

}