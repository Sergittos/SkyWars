<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\game\challenge\presets;


use pocketmine\item\VanillaItems;
use sergittos\skywars\game\challenge\Challenge;
use sergittos\skywars\session\Session;
use sergittos\skywars\utils\ItemInfo;

class Rookie extends Challenge {

    public function __construct() {
        parent::__construct("Rookie", "You must play the game without a kit and perks", new ItemInfo(32, VanillaItems::WOODEN_PICKAXE()));
    }

    public function onGameStart(Session $session): void {
        $session->clearInventories();
        // TODO: Disable perks
    }

}