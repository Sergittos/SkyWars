<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\game\kit\presets;


use pocketmine\block\VanillaBlocks;
use pocketmine\item\EnchantedBook;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\enchantment\VanillaEnchantments;
use pocketmine\item\VanillaItems;
use sergittos\skywars\game\kit\Kit;
use sergittos\skywars\game\kit\Rarity;

class Armorsmith extends Kit {

    public function __construct() {
        parent::__construct("Armorsmith", Rarity::COMMON);
    }

    protected function getNormalContents(): array {
        return [
            VanillaBlocks::ANVIL()->asItem(),
            VanillaItems::ENCHANTED_BOOK()
                ->addEnchantment(new EnchantmentInstance(VanillaEnchantments::PROTECTION(), 3))
                ->addEnchantment(new EnchantmentInstance(VanillaEnchantments::SHARPNESS(), 1)),
            VanillaItems::EXPERIENCE_BOTTLE()->setCount(64)
        ];
    }

    protected function getNormalArmorContents(): array {
        return [
            VanillaItems::DIAMOND_HELMET()
        ];
    }

    protected function getInsaneContents(): array {
        return [
            VanillaBlocks::ANVIL()->asItem(),
            VanillaItems::ENCHANTED_BOOK()
                ->addEnchantment(new EnchantmentInstance(VanillaEnchantments::PROTECTION(), 4))
                ->addEnchantment(new EnchantmentInstance(VanillaEnchantments::SHARPNESS(), 1))
                ->addEnchantment(new EnchantmentInstance(VanillaEnchantments::INFINITY(), 1)),
            VanillaItems::EXPERIENCE_BOTTLE()->setCount(64)
        ];
    }

    protected function getInsaneArmorContents(): array {
        return [
            VanillaItems::DIAMOND_HELMET()
        ];
    }

}