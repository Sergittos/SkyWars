<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\listener;


use pocketmine\event\Listener;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\event\player\PlayerQuitEvent;
use sergittos\skywars\session\SessionFactory;

class SessionListener implements Listener {

    public function onLogin(PlayerLoginEvent $event): void {
        SessionFactory::createSession($event->getPlayer());
    }

    /**
     * @priority HIGHEST
     */
    public function onQuit(PlayerQuitEvent $event): void {
        SessionFactory::removeSession($event->getPlayer());
    }

}