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

class BaseballPlayer extends Kit {

    public function __construct() {
        parent::__construct("Baseball Player", Rarity::RARE);
    }

    protected function getNormalContents(): array {
        return [
            VanillaItems::WOODEN_SWORD()->addEnchantment(new EnchantmentInstance(VanillaEnchantments::KNOCKBACK()))
        ];
    }

    protected function getNormalArmorContents(): array {
        return [
            VanillaItems::IRON_HELMET()->addEnchantment(new EnchantmentInstance(VanillaEnchantments::PROTECTION())),
        ];
    }

    protected function getInsaneContents(): array {
        return [
            VanillaItems::STONE_SWORD()->addEnchantment(new EnchantmentInstance(VanillaEnchantments::KNOCKBACK()))
        ];
    }

    protected function getInsaneArmorContents(): array {
        return [
            VanillaItems::CHAINMAIL_HELMET()->addEnchantment(new EnchantmentInstance(VanillaEnchantments::PROTECTION(), 4)),
        ];
    }

}