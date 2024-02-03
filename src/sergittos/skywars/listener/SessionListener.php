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
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\event\player\PlayerQuitEvent;
use sergittos\skywars\session\SessionFactory;
use sergittos\skywars\SkyWars;

class SessionListener implements Listener {

    public function onLogin(PlayerLoginEvent $event): void {
        SessionFactory::createSession($event->getPlayer());
    }

    public function onJoin(PlayerJoinEvent $event): void {
        SessionFactory::getSession($event->getPlayer())->updateScoreboard();
    }

    public function onChat(PlayerChatEvent $event): void { // just for testing
        SkyWars::getInstance()->getGameManager()->getGames()[0]->addPlayer(SessionFactory::getSession($event->getPlayer()));
    }

    /**
     * @priority HIGHEST
     */
    public function onQuit(PlayerQuitEvent $event): void {
        SessionFactory::removeSession($event->getPlayer());
    }

}