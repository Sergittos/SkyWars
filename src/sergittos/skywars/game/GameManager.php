<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\game;


class GameManager {

    private int $next_game_id = 0;

    /** @var Game[] */
    private array $games = [];

    public function __construct() {

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

    public function addGame(Game $game): void {
        $this->games[$game->getId()] = $game;
    }

    public function removeGame(int $id): void {
        unset($this->games[$id]);
    }

}