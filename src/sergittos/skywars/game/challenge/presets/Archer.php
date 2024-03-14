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
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\item\VanillaItems;
use sergittos\skywars\game\challenge\GameChallenge;
use sergittos\skywars\session\Session;
use sergittos\skywars\utils\ItemInfo;
use sergittos\skywars\utils\message\MessageContainer;

class Archer extends GameChallenge {

    public function __construct() {
        parent::__construct("Archer", "You cannot deal any melee damage during the game", new ItemInfo(5, VanillaItems::BOW()));
    }

    public function onFight(Session $session, Session $victim, Cancellable $event, int $cause): void {
        if($cause === EntityDamageEvent::CAUSE_ENTITY_ATTACK) {
            $event->cancel();

            $session->sendMessage(new MessageContainer("CANNOT_DEAL_MELEE_DAMAGE"));
        }
    }

}