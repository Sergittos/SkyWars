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

class Armorer extends Kit {

    public function __construct() {
        parent::__construct("Armorer", Rarity::RARE);
    }

    protected function getNormalArmorContents(): array {
        return [
            VanillaItems::GOLDEN_CHESTPLATE(),
            VanillaItems::GOLDEN_LEGGINGS()
        ];
    }

    protected function getInsaneArmorContents(): array {
        return [
            VanillaItems::DIAMOND_CHESTPLATE(),
            VanillaItems::IRON_LEGGINGS()
        ];
    }

    protected function getInsaneContents(): array {
        return [
            // TODO: Potion of Resistance 1 (10s)
        ];
    }

}