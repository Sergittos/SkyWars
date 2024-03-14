<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\game;


use pocketmine\Server;
use sergittos\skywars\game\map\Map;
use sergittos\skywars\game\map\MapFactory;
use sergittos\skywars\game\task\DirectoryCopyTask;
use sergittos\skywars\session\Session;

class GameManager {

    private int $nextGameId = 0;

    /** @var Game[] */
    private array $games = [];

    public function __construct() {
        MapFactory::init(); // maybe this should be called in the main class
    }

    public function getNextGameId(): int {
        return $this->nextGameId++;
    }

    /**
     * @return Game[]
     */
    public function getGames(): array {
        return $this->games;
    }

    /**
     * @return Game[]
     */
    public function getAvailableGames(Map $map): array {
        $games = [];
        foreach($this->games as $game) {
            if($game->getMap() === $map and $game->canBeJoined()) {
                $games[] = $game;
            }
        }
        return $games;
    }

    public function findGame(Map $map, ?Session $session = null): void {
        $games = $this->getAvailableGames($map);
        if(count($games) === 0) {
            $this->generateGame($map, $session);
        } else {
            $games[0]->addPlayer($session);
        }
    }

    private function generateGame(Map $map, ?Session $session = null): void {
        $id = $this->getNextGameId();

        Server::getInstance()->getAsyncPool()->submitTask(new DirectoryCopyTask($map->getWorldPath(), $map->createWorldPath($id), function() use ($map, $session, $id): void {
            $this->addGame($game = new Game($map, $id));
            if($session !== null) {
                $game->addPlayer($session);
            }
        }));
    }

    public function addGame(Game $game): void {
        $this->games[$game->getId()] = $game;
    }

    public function removeGame(int $id): void {
        unset($this->games[$id]);
    }

}