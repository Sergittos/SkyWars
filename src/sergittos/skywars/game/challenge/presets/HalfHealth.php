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
use sergittos\skywars\game\challenge\GameChallenge;
use sergittos\skywars\session\Session;
use sergittos\skywars\utils\ItemInfo;

class HalfHealth extends GameChallenge {

    public function __construct() {
        parent::__construct("Half Health", "You only have 5 hearts", new ItemInfo(7, VanillaItems::GLISTERING_MELON()));
    }

    public function onGameStart(Session $session): void {
        $session->getPlayer()->setMaxHealth(10);
    }

}