<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\utils;


use pocketmine\block\utils\DyeColor;
use pocketmine\item\Dye;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\enchantment\VanillaEnchantments;
use pocketmine\item\Item;
use pocketmine\utils\TextFormat;
use sergittos\skywars\game\challenge\GameChallenge;
use sergittos\skywars\session\Session;
use function array_map;
use function strlen;
use function substr;

class ItemInfo {

    private int $slot;

    private Item $item;

    private bool $enchant;

    public function __construct(int $slot, Item $item, bool $enchant = true) {
        $this->slot = $slot;
        $this->item = $item;
        $this->enchant = $enchant;
    }

    public function getSlot(): int {
        return $this->slot;
    }

    public function getItem(Session $session, GameChallenge $challenge): Item {
        $item = clone $this->item;
        $item->setCustomName(TextFormat::YELLOW . $challenge->getName() . " GameChallenge");
        $item->getNamedTag()->setString("skywars_challenge", $challenge->getName());
        $item->setLore(array_map(fn(string $line) => TextFormat::GRAY . $line, $this->createLore($session, $challenge)));

        if($item instanceof Dye) {
            $item->setColor($session->hasSelectedChallenge($challenge) ? DyeColor::LIME : DyeColor::GRAY);
        } elseif($session->hasSelectedChallenge($challenge) and $this->enchant) {
            $item->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING()));
        }

        return $item;
    }

    /**
     * @return string[]
     */
    private function createLore(Session $session, GameChallenge $challenge): array {
        $lore = $this->splitTextIntoChunks($challenge->getDescription());
        $lore[] = "";
        $lore[] = "Status: " . ($session->hasSelectedChallenge($challenge) ? TextFormat::GREEN . "Active" : TextFormat::RED . "Inactive");
        $lore[] = "";
        $lore[] = TextFormat::YELLOW . "Click to toggle!";

        return $lore;
    }

    /**
     * @return string[]
     */
    private function splitTextIntoChunks(string $text): array {
        $chunks = [];
        for($i = 0; $i < strlen($text); $i += 35) {
            $chunks[] = substr($text, $i, 35);
        }
        return $chunks;
    }

}