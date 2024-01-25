<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars;


use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use sergittos\skywars\game\GameHeartbeat;
use sergittos\skywars\game\GameManager;
use sergittos\skywars\listener\SessionListener;

class SkyWars extends PluginBase {
    use SingletonTrait;

    private GameManager $gameManager;

    protected function onLoad(): void {
        self::setInstance($this);
    }

    protected function onEnable(): void {
        $this->gameManager = new GameManager();

        $this->registerListener(new SessionListener());

        $this->getScheduler()->scheduleRepeatingTask(new GameHeartbeat(), 20);
    }

    private function registerListener(Listener $listener): void {
        $this->getServer()->getPluginManager()->registerEvents($listener, $this);
    }

    public function getGameManager(): GameManager {
        return $this->gameManager;
    }

}