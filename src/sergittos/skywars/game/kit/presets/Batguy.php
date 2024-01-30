<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\game\kit\presets;


use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\enchantment\VanillaEnchantments;
use pocketmine\item\VanillaItems;
use sergittos\skywars\game\kit\Kit;
use sergittos\skywars\game\kit\Rarity;

class Batguy extends Kit {

    public function __construct() {
        parent::__construct("Batguy", Rarity::COMMON);
    }

    protected function getNormalContents(): array {
        return [
            // TODO: Batguy's Potion (8s of Blindness) & 5x Bat Egg
        ];
    }

    protected function getNormalArmorContents(): array {
        return [
            VanillaItems::LEATHER_CAP(),
            VanillaItems::LEATHER_TUNIC(),
            VanillaItems::LEATHER_PANTS(),
            VanillaItems::LEATHER_BOOTS()
        ];
    }

    protected function getInsaneContents(): array {
        return [
            // TODO: Batguy's Potion (11s of Blindness) & 10x Bat Egg
        ];
    }

    protected function getInsaneArmorContents(): array {
        $protection = new EnchantmentInstance(VanillaEnchantments::PROTECTION(), 2);
        return [
            VanillaItems::IRON_HELMET()->addEnchantment($protection),
            VanillaItems::LEATHER_TUNIC(),
            VanillaItems::LEATHER_PANTS(),
            VanillaItems::IRON_BOOTS()->addEnchantment($protection)
        ];
    }

}