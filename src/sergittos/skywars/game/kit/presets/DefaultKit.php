<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\game\kit\presets;


use pocketmine\item\VanillaItems;
use sergittos\skywars\game\kit\Kit;
use sergittos\skywars\game\kit\Rarity;

class DefaultKit extends Kit {

    public function __construct() {
        parent::__construct("Default", Rarity::COMMON);
    }

    protected function getNormalContents(): array {
        return [
            VanillaItems::STONE_PICKAXE(),
            VanillaItems::STONE_AXE(),
            VanillaItems::STONE_SHOVEL()
        ];
    }

    protected function getInsaneContents(): array {
        return [
            VanillaItems::IRON_PICKAXE(),
            VanillaItems::IRON_AXE(),
            VanillaItems::IRON_SHOVEL()
        ];
    }

}