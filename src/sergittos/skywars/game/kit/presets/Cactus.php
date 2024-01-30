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
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\enchantment\VanillaEnchantments;
use pocketmine\item\VanillaItems;
use sergittos\skywars\game\kit\Kit;
use sergittos\skywars\game\kit\Rarity;

class Cactus extends Kit {

    public function __construct() {
        parent::__construct("Cactus", Rarity::COMMON);
    }

    protected function getNormalContents(): array {
        return [
            VanillaBlocks::CACTUS()->asItem()->setCount(8),
            VanillaBlocks::SAND()->asItem()->setCount(16)
        ];
    }

    protected function getNormalArmorContents(): array {
        return [
            VanillaItems::LEATHER_TUNIC()
                ->addEnchantment(new EnchantmentInstance(VanillaEnchantments::THORNS(), 5))
                ->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 3))
        ];
    }

    protected function getInsaneContents(): array {
        return [
            VanillaBlocks::CACTUS()->asItem()->setCount(16),
            VanillaBlocks::SAND()->asItem()->setCount(32)
        ];
    }

    protected function getInsaneArmorContents(): array {
        return [
            VanillaItems::LEATHER_TUNIC()
                ->addEnchantment(new EnchantmentInstance(VanillaEnchantments::THORNS(), 5))
                ->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 3)),
            VanillaItems::LEATHER_PANTS()
                ->addEnchantment(new EnchantmentInstance(VanillaEnchantments::THORNS(), 3))
                ->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 3)),
        ];
    }

}