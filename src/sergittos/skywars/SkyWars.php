<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars;


use muqsit\invmenu\InvMenuHandler;
use pocketmine\block\tile\TileFactory;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use sergittos\skywars\game\chest\ChestTile;
use sergittos\skywars\game\GameHeartbeat;
use sergittos\skywars\game\GameManager;
use sergittos\skywars\listener\GameListener;
use sergittos\skywars\listener\ItemListener;
use sergittos\skywars\listener\SessionListener;
use sergittos\skywars\utils\message\MessageManager;
use function is_dir;

class SkyWars extends PluginBase {
    use SingletonTrait;

    private GameManager $gameManager;
    private MessageManager $messageManager;

    protected function onLoad(): void {
        $worldsDir = $this->getDataFolder() . "worlds";
        if(!is_dir($worldsDir)) {
            mkdir($worldsDir);
        }
        self::setInstance($this);

        $this->saveResource("maps.json", true); // TODO: Set "replace" to false on production
        $this->saveResource("messages.json", true); // TODO: Set "replace" to false on production
    }

    protected function onEnable(): void {
        if(!InvMenuHandler::isRegistered()) {
            InvMenuHandler::register($this);
        }

        TileFactory::getInstance()->register(ChestTile::class, ["Chest", "minecraft:chest"]);

        $this->gameManager = new GameManager();
        $this->messageManager = new MessageManager();

        $this->registerListener(new GameListener());
        $this->registerListener(new ItemListener());
        $this->registerListener(new SessionListener());

        $this->getScheduler()->scheduleRepeatingTask(new GameHeartbeat(), 20);
    }

    protected function onDisable(): void {
        foreach($this->gameManager->getGames() as $game) {
            $game->unloadWorld();
        }
    }

    private function registerListener(Listener $listener): void {
        $this->getServer()->getPluginManager()->registerEvents($listener, $this);
    }

    public function getGameManager(): GameManager {
        return $this->gameManager;
    }

    public function getMessageManager(): MessageManager {
        return $this->messageManager;
    }

}