<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\game;


use pocketmine\math\Vector3;
use sergittos\skywars\game\map\Map;
use sergittos\skywars\game\map\Mode;
use sergittos\skywars\game\team\Team;

class GameManager {

    private int $next_game_id = 0;

    /** @var Game[] */
    private array $games = [];

    public function __construct() { // just for testing
        $this->addGame(new Game(new Map(
            "map1",
            "Tree",
            Vector3::zero(),
            Mode::SOLOS,
            2,
            [
                new Team("red", new Vector3(203, 15, 228), 1),
                new Team("blue", new Vector3(224, 15, 228), 1),
            ]
        ), $this->getNextGameId()));
    }

    public function getNextGameId(): int {
        return $this->next_game_id++;
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

    public function generateGame(Map $map): void {

    }

    public function addGame(Game $game): void {
        $this->games[$game->getId()] = $game;
    }

    public function removeGame(int $id): void {
        unset($this->games[$id]);
    }

}