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
use pocketmine\block\BlockTypeIds;
use pocketmine\block\VanillaBlocks;
use pocketmine\event\Cancellable;
use pocketmine\event\player\PlayerInteractEvent;
use sergittos\skywars\game\challenge\Challenge;
use sergittos\skywars\session\Session;
use sergittos\skywars\utils\ItemInfo;
use sergittos\skywars\utils\message\MessageContainer;

class NoChest extends Challenge {

    public function __construct() {
        parent::__construct("No Chest", "You cannot open any chests during the game", new ItemInfo(3, VanillaBlocks::CHEST()->asItem(), false));
    }

    public function onInteract(Session $session, Block $block, Cancellable $event, int $action): void {
        if($action === PlayerInteractEvent::RIGHT_CLICK_BLOCK and $block->getTypeId() === BlockTypeIds::CHEST) {
            $event->cancel();

            $session->sendMessage(new MessageContainer("CANNOT_OPEN_CHESTS"));
        }
    }

    public function onBlockBreak(Session $session, Block $block, Cancellable $event): void {
        if($block->getTypeId() === BlockTypeIds::CHEST) {
            $event->cancel();

            $session->sendMessage(new MessageContainer("CANNOT_BREAK_CHESTS"));
        }
    }

}