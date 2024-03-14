<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\game\challenge;


use pocketmine\block\Block;
use pocketmine\event\Cancellable;
use pocketmine\inventory\transaction\InventoryTransaction;
use pocketmine\item\Item;
use sergittos\skywars\session\Session;
use sergittos\skywars\utils\ItemInfo;

abstract class GameChallenge {

    private string $name;
    private string $description;

    private ItemInfo $itemInfo;

    public function __construct(string $name, string $description, ItemInfo $itemInfo) {
        $this->name = $name;
        $this->description = $description;
        $this->itemInfo = $itemInfo;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getItemInfo(): ItemInfo {
        return $this->itemInfo;
    }

    public function onGameStart(Session $session): void {}

    public function onFight(Session $session, Session $victim, Cancellable $event, int $cause): void {}

    public function onInteract(Session $session, Block $block, Cancellable $event, int $action): void {}

    public function onItemUse(Session $session, Item $item, Cancellable $event): void {}

    public function onBlockPlace(Session $session, Block $block, Cancellable $event): void {}

    public function onBlockBreak(Session $session, Block $block, Cancellable $event): void {}

    public function onItemPickup(Session $session, Item $item, Cancellable $event): void {}

    public function onRegainHealth(Session $session, Cancellable $event): void {}

    public function onInventoryTransaction(Session $session, InventoryTransaction $transaction, Cancellable $event): void {}

}