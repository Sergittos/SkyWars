<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\listener;


use Closure;
use pocketmine\block\BlockTypeIds;
use pocketmine\block\Chest as ChestBlock;
use pocketmine\block\tile\Chest as ChestTile;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityItemPickupEvent;
use pocketmine\event\entity\EntityRegainHealthEvent;
use pocketmine\event\inventory\InventoryOpenEvent;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerItemUseEvent;
use pocketmine\item\Item;
use pocketmine\item\VanillaItems;
use pocketmine\player\Player;
use sergittos\skywars\game\challenge\GameChallenge;
use sergittos\skywars\game\chest\ChestInventory;
use sergittos\skywars\game\stage\PlayingStage;
use sergittos\skywars\session\Session;
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

        foreach($session->getSelectedChallenges() as $challenge) {
            $challenge->onBlockBreak($session, $event->getBlock(), $event);
        }

        $block = $event->getBlock();
        if(!$block instanceof ChestBlock) {
            $this->dropMeltedOre($event);
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

        foreach($damagerSession->getSelectedChallenges() as $challenge) {
            $challenge->onFight($damagerSession, $entitySession, $event, $event->getCause());
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

        $stage = $session->getGame()->getStage();
        if($stage instanceof PlayingStage and !$stage->isGraceTimeOver()) {
            $event->cancel();
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
        $player = $event->getPlayer();
        if(SessionFactory::getSession($player)->isSpectator()) {
            $event->uncancel();
        } else {
            $this->checkChallenges($player, fn(Session $session, GameChallenge $challenge) => $challenge->onItemUse($session, $event->getItem(), $event));
        }
    }

    public function onPlace(BlockPlaceEvent $event): void {
        $this->checkChallenges($event->getPlayer(), fn(Session $session, GameChallenge $challenge) => $challenge->onBlockPlace($session, $event->getBlockAgainst(), $event));
    }

    public function onInteract(PlayerInteractEvent $event): void {
        $this->checkChallenges($event->getPlayer(), fn(Session $session, GameChallenge $challenge) => $challenge->onInteract($session, $event->getBlock(), $event, $event->getAction()));
    }

    public function onItemPickup(EntityItemPickupEvent $event): void {
        $entity = $event->getEntity();
        if($entity instanceof Player) {
            $this->checkChallenges($entity, fn(Session $session, GameChallenge $challenge) => $challenge->onItemPickup($session, $event->getItem(), $event));
        }
    }

    public function onRegainHealth(EntityRegainHealthEvent $event): void {
        $entity = $event->getEntity();
        if($entity instanceof Player) {
            $this->checkChallenges($entity, fn(Session $session, GameChallenge $challenge) => $challenge->onRegainHealth($session, $event));
        }
    }

    public function onInventoryTransaction(InventoryTransactionEvent $event): void {
        $transaction = $event->getTransaction();
        $this->checkChallenges($transaction->getSource(), fn(Session $session, GameChallenge $challenge) => $challenge->onInventoryTransaction($session, $transaction, $event));
    }

    private function dropMeltedOre(BlockBreakEvent $event): void {
        $event->setDrops(match($event->getBlock()->getTypeId()) {
            BlockTypeIds::COAL_ORE => [VanillaItems::COAL()],
            BlockTypeIds::COPPER_ORE => [VanillaItems::COPPER_INGOT()],
            BlockTypeIds::DIAMOND_ORE => [VanillaItems::DIAMOND()],
            BlockTypeIds::EMERALD_ORE => [VanillaItems::EMERALD()],
            BlockTypeIds::GOLD_ORE => [VanillaItems::GOLD_INGOT()],
            BlockTypeIds::IRON_ORE => [VanillaItems::IRON_INGOT()],
            BlockTypeIds::LAPIS_LAZULI_ORE => [VanillaItems::LAPIS_LAZULI()],
            BlockTypeIds::REDSTONE_ORE => [VanillaItems::REDSTONE_DUST()],
            default => $event->getDrops()
        });
    }

    /**
     * @param (Closure(Session, GameChallenge): void) $closure
     */
    private function checkChallenges(Player $player, Closure $closure): void {
        $session = SessionFactory::getSession($player);
        if($session->isPlaying()) {
            foreach($session->getSelectedChallenges() as $challenge) {
                $closure($session, $challenge);
            }
        }
    }

}