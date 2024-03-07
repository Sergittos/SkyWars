<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\game\challenge\presets;


use pocketmine\block\Block;
use pocketmine\block\VanillaBlocks;
use pocketmine\event\Cancellable;
use pocketmine\inventory\transaction\InventoryTransaction;
use pocketmine\item\Item;
use pocketmine\item\ItemBlock;
use sergittos\skywars\game\challenge\Challenge;
use sergittos\skywars\session\Session;
use sergittos\skywars\utils\ItemInfo;
use sergittos\skywars\utils\message\MessageContainer;

class NoBlock extends Challenge {

    public function __construct() {
        parent::__construct("No Block", "You cannot use blocks during the game", new ItemInfo(30, VanillaBlocks::BEDROCK()->asItem()));
    }

    public function onItemPickup(Session $session, Item $item, Cancellable $event): void {
        if($item instanceof ItemBlock) {
            $event->cancel();
        }
    }

    public function onBlockBreak(Session $session, Block $block, Cancellable $event): void {
        $event->setDrops([]);
    }

    public function onBlockPlace(Session $session, Block $block, Cancellable $event): void {
        $event->cancel();

        $session->sendMessage(new MessageContainer("CANNOT_USE_BLOCKS"));
    }

    public function onInventoryTransaction(Session $session, InventoryTransaction $transaction, Cancellable $event): void {
        foreach($transaction->getActions() as $action) {
            if($action->getSourceItem() instanceof ItemBlock) {
                $event->cancel();

                $session->sendMessage(new MessageContainer("CANNOT_USE_BLOCKS"));
                return;
            }
        }
    }

}