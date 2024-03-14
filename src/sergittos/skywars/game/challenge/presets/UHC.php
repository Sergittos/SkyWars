<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\game\challenge\presets;


use pocketmine\event\Cancellable;
use pocketmine\item\VanillaItems;
use sergittos\skywars\game\challenge\GameChallenge;
use sergittos\skywars\session\Session;
use sergittos\skywars\utils\ItemInfo;

class UHC extends GameChallenge {

    public function __construct() {
        parent::__construct("UHC", "You cannot naturally regenerate health during the game", new ItemInfo(1, VanillaItems::GOLDEN_APPLE(), false));
    }

    public function onRegainHealth(Session $session, Cancellable $event): void {
        $event->cancel();
    }

}