<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\game\chest;


use pocketmine\block\tile\Chest;
use pocketmine\math\Vector3;
use pocketmine\world\World;

class ChestTile extends Chest {

    public function __construct(World $world, Vector3 $pos) {
        parent::__construct($world, $pos);

        $this->inventory = new ChestInventory($this->position);
    }

}