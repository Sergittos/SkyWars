<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\game\challenge\presets;


use pocketmine\event\Cancellable;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\inventory\ArmorInventory;
use pocketmine\inventory\transaction\InventoryTransaction;
use pocketmine\item\Armor;
use pocketmine\item\Item;
use pocketmine\item\ItemTypeIds;
use pocketmine\item\VanillaItems;
use sergittos\skywars\game\challenge\Challenge;
use sergittos\skywars\session\Session;
use sergittos\skywars\utils\ItemInfo;
use sergittos\skywars\utils\message\MessageContainer;

class UltimateWarrior extends Challenge {

    public function __construct() {
        parent::__construct("Ultimate Warrior", "You spawn with only a Stone Sword, cannot use other swords or bows, and cannot wear armor", new ItemInfo(28, VanillaItems::STONE_SWORD()));
    }

    public function onGameStart(Session $session): void {
        $player = $session->getPlayer();
        $inventory = $player->getInventory();

        $armorInventory = $player->getArmorInventory();
        foreach($armorInventory->getContents() as $item) {
            $inventory->addItem($item);
        }
        $armorInventory->clearAll();

        $inventory->addItem(VanillaItems::STONE_SWORD());
    }

    public function onItemPickup(Session $session, Item $item, Cancellable $event): void {
        if($item instanceof Armor) {
            $event->cancel();
        }
    }

    public function onItemUse(Session $session, Item $item, Cancellable $event): void {
        if($item instanceof Armor) {
            $event->cancel();

            $session->sendMessage(new MessageContainer("CANNOT_WEAR_ARMOR"));
        }
    }

    public function onInventoryTransaction(Session $session, InventoryTransaction $transaction, Cancellable $event): void {
        foreach($transaction->getInventories() as $inventory) {
            if(!$inventory instanceof ArmorInventory) {
                continue;
            }

            foreach($transaction->getActions() as $action) {
                if(!$action->getSourceItem() instanceof Armor) {
                    continue;
                }
                $event->cancel();

                $session->sendMessage(new MessageContainer("CANNOT_WEAR_ARMOR"));
                return;
            }
        }
    }

    public function onFight(Session $session, Session $victim, Cancellable $event, int $cause): void {
        if($cause === EntityDamageEvent::CAUSE_PROJECTILE) {
            $event->cancel();

            $session->sendMessage(new MessageContainer("CANNOT_DEAL_PROJECTILE_DAMAGE"));
            return;
        }

        if($session->getPlayer()->getInventory()->getItemInHand()->getTypeId() !== ItemTypeIds::STONE_SWORD) {
            $event->cancel();

            $session->sendMessage(new MessageContainer("CAN_ONLY_USE_STONE_SWORD"));
        }
    }

}