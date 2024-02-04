<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\item\spectator;


use pocketmine\block\VanillaBlocks;
use pocketmine\item\Item;
use sergittos\skywars\session\Session;
use sergittos\skywars\utils\message\MessageContainer;

class SpectatorSettingsItem extends SpectatorItem {

    public function __construct() {
        parent::__construct("spectator_settings", new MessageContainer("SPECTATOR_SETTINGS"));
    }

    public function onInteract(Session $session): void {
        // TODO: Implement onInteract() method.
    }

    protected function realItem(): Item {
        return VanillaBlocks::REDSTONE_COMPARATOR()->asItem();
    }

}