<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\game\cage;


use pocketmine\world\Position;

abstract class Cage {

    public function __construct() {

    }

    abstract public function build(Position $position): void;

}