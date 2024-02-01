<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\game\cage;


use pocketmine\block\VanillaBlocks;
use pocketmine\math\Vector3;
use pocketmine\world\BlockTransaction;
use pocketmine\world\Position;
use pocketmine\world\World;

abstract class Cage {

    protected ?BlockTransaction $transaction = null;

    public function __construct() {

    }

    abstract public function setBlocks(Vector3 $position): void;

    public function build(Position $position): void {
        $this->transaction = new BlockTransaction($position->getWorld());
        $this->setBlocks($position);
        $this->transaction->apply();
    }

    public function destroy(World $world): void {
        if($this->transaction !== null) {
            foreach($this->transaction->getBlocks() as [$x, $y, $z, $block]) {
                $world->setBlockAt($x, $y, $z, VanillaBlocks::AIR());
            }
            $this->transaction = null;
        }
    }

}