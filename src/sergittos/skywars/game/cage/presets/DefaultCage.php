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
use pocketmine\block\VanillaBlocks;
use pocketmine\math\Vector3;
use sergittos\skywars\game\cage\Cage;

class DefaultCage extends Cage {

    protected function setBlocks(Vector3 $position): void {
        $block = $this->getFillingBlock();

        for($y = -1; $y <= 4; $y++) {
            for($i = -1; $i <= 1; $i += 2) {
                $this->transaction->addBlock($position->add($i, $y, 0), $block);
                $this->transaction->addBlock($position->add(0, $y, $i), $block);

                if($y === -1 or $y === 4) {
                    $this->transaction->addBlock($position->add(0, $y, 0), $block);
                }
            }
        }
    }

    protected function getFillingBlock(): Block {
        return VanillaBlocks::GLASS();
    }

}