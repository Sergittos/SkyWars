<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\listener;


use pocketmine\block\Chest as ChestBlock;
use pocketmine\block\inventory\ChestInventory;
use pocketmine\block\tile\Chest as ChestTile;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\inventory\InventoryOpenEvent;
use pocketmine\event\Listener;
use pocketmine\item\Item;
use sergittos\skywars\session\SessionFactory;
use function array_filter;

class GameListener implements Listener {

    public function onInventoryOpen(InventoryOpenEvent $event): void {
        $session = SessionFactory::getSession($event->getPlayer());
        if(!$session->isPlaying()) {
            return;
        }

        $inventory = $event->getInventory();
        if(!$inventory instanceof ChestInventory) {
            return;
        }

        $session->getGame()->openChest($inventory);
    }

    public function onBreak(BlockBreakEvent $event): void {
        $session = SessionFactory::getSession($event->getPlayer());
        if(!$session->isPlaying()) {
            return;
        }

        $block = $event->getBlock();
        if(!$block instanceof ChestBlock) {
            return;
        }

        $game = $session->getGame();
        $tile = $game->getWorld()->getTile($block->getPosition());

        if($tile instanceof ChestTile and ($inventory = $tile->getInventory()) instanceof ChestInventory) {
            $game->closeChest($inventory);
            
            $event->setDrops(array_filter($event->getDrops(), fn(Item $item) => $inventory->contains($item)));
        }
    }

}