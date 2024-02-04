<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\utils;


use pocketmine\item\VanillaItems;
use sergittos\skywars\game\chest\ChestInventory;

class InventoryUtils {

    static public function fillChest(ChestInventory $inventory): void {
        $inventory->setContents([
            VanillaItems::STEAK()->setCount(3),
            VanillaItems::WOODEN_SWORD(),
            VanillaItems::WOODEN_AXE(),
            VanillaItems::WOODEN_PICKAXE(),
        ]);
    }

}