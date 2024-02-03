<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\game\map;


use pocketmine\math\Vector3;
use pocketmine\world\World;
use sergittos\skywars\game\team\Team;

class Map {
    use MapProperties;

    /** @var Team[] */
    private array $teams;

    /**
     * @param Team[] $teams
     */
    public function __construct(string $id, string $name, Vector3 $spectatorSpawnPosition, Mode $mode, int $slots, array $teams) {
        $this->id = $id;
        $this->name = $name;
        $this->spectatorSpawnPosition = $spectatorSpawnPosition;
        $this->mode = $mode;
        $this->slots = $slots;
        $this->teams = $teams;
    }

    /**
     * @return Team[]
     */
    public function getTeams(): array {
        return $this->teams;
    }

}