<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\utils;


use sergittos\skywars\SkyWars;

class ConfigGetter {

    static private function get(string $key): mixed {
        return SkyWars::getInstance()->getConfig()->get($key);
    }

}