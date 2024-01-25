<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\game\cage\presets;


use pocketmine\block\VanillaBlocks;
use pocketmine\world\Position;

class Nicolas extends DefaultCage {

    public function build(Position $position): void {
        foreach($this->getBlocks($position) as $block) {
            $position->getWorld()->setBlock($block, VanillaBlocks::MONSTER_SPAWNER());
        }
    }

}