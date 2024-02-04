<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\item\game;


use pocketmine\block\utils\DyeColor;
use pocketmine\block\VanillaBlocks;
use pocketmine\item\Item;
use sergittos\skywars\session\Session;
use sergittos\skywars\utils\message\MessageContainer;

class LeaveGameItem extends GameItem {

    public function __construct() {
        parent::__construct("leave_game", new MessageContainer("RETURN_TO_LOBBY"));
    }

    public function onInteract(Session $session): void {
        $session->getGame()->removePlayer($session);
    }

    protected function realItem(): Item {
        return VanillaBlocks::BED()->setColor(DyeColor::RED)->asItem();
    }

}