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
use pocketmine\math\Vector3;
use pocketmine\world\Position;
use sergittos\skywars\game\cage\Cage;

class DefaultCage extends Cage {

    public function build(Position $position): void {
        foreach($this->getBlocks($position) as $block) {
            $position->getWorld()->setBlock($block, VanillaBlocks::GLASS());
        }
    }

    /**
     * @return Vector3[]
     */
    protected function getBlocks(Vector3 $position): array {
        $blocks = [];
        for($y = -1; $y <= 4; $y++) {
            for($i = -1; $i <= 1; $i += 2) {
                $blocks[] = $position->add($i, $y, 0);
                $blocks[] = $position->add(0, $y, $i);

                if($y === -1 or $y === 4) {
                    $blocks[] = $position->add(0, $y, 0);
                }
            }
        }
        return $blocks;
    }

}