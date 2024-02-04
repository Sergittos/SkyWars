<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\game\chest;


use pocketmine\block\inventory\ChestInventory as PMChestInventory;
use pocketmine\player\Player;

class ChestInventory extends PMChestInventory {

    private bool $needsRefill = false;

    public function onOpen(Player $who): void {
        if(!$this->needsRefill) {
            $this->needsRefill = true;
            parent::onOpen($who);
        }
    }

    public function onClose(Player $who): void {
        if(!$this->needsRefill) {
            parent::onClose($who);
        }
    }

    public function setNeedsRefill(bool $needsRefill): void {
        $this->needsRefill = $needsRefill;
        $this->animateBlock(false);
    }

}