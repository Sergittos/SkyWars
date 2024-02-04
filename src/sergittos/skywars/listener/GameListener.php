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
use pocketmine\block\tile\Chest as ChestTile;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\inventory\InventoryOpenEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemUseEvent;
use pocketmine\item\Item;
use pocketmine\player\Player;
use sergittos\skywars\game\chest\ChestInventory;
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

    public function onFight(EntityDamageByEntityEvent $event): void {
        $damager = $event->getDamager();
        $entity = $event->getEntity();

        if(!$damager instanceof Player or !$entity instanceof Player or !SessionFactory::hasSession($damager) or !SessionFactory::hasSession($entity)) {
            return;
        }

        $damagerSession = SessionFactory::getSession($damager);
        $entitySession = SessionFactory::getSession($entity);

        if(!$damagerSession->isPlaying() or !$entitySession->isPlaying()) {
            return;
        }

        if($damagerSession->getTeam()->hasMember($entitySession)) {
            $event->cancel();
        } else {
            $entitySession->setLastSessionHit($damagerSession);
        }
    }

    public function onReceiveDamage(EntityDamageEvent $event): void {
        $entity = $event->getEntity();
        if(!$entity instanceof Player) {
            return;
        }

        $session = SessionFactory::getSession($entity);
        if(!$session->isPlaying()) {
            return;
        }

        if($event->getFinalDamage() >= $entity->getHealth()) {
            $session->kill($event->getCause());
            $event->cancel();
        }
    }

    /**
     * @handleCancelled
     */
    public function onItemUse(PlayerItemUseEvent $event): void {
        if(SessionFactory::getSession($event->getPlayer())->isSpectator()) {
            $event->uncancel();
        }
    }

}