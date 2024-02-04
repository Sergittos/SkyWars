<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\item\game;


use pocketmine\item\Item;
use pocketmine\item\VanillaItems;
use sergittos\skywars\session\Session;
use sergittos\skywars\utils\message\MessageContainer;

class KitSelectorItem extends GameItem {

    public function __construct() {
        parent::__construct("kit_selector", new MessageContainer("KIT_SELECTOR"));
    }

    public function onInteract(Session $session): void {
        // TODO: Send kit selector form
    }

    protected function realItem(): Item {
        return VanillaItems::BOW();
    }

}