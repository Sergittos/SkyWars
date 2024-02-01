<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\game\cage\presets;


use pocketmine\block\Block;
use pocketmine\block\utils\DyeColor;
use pocketmine\block\VanillaBlocks;

class Dark extends DefaultCage {

    protected function getFillingBlock(): Block {
        return VanillaBlocks::STAINED_GLASS()->setColor(DyeColor::BLACK);
    }

}