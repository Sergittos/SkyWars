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

trait MapProperties {

    protected string $id;
    protected string $name;

    protected World $waitingWorld;
    protected Vector3 $spectatorSpawnPosition;
    protected Mode $mode;

    protected int $slots;

    public function getId(): string {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getWaitingWorld(): World {
        return $this->waitingWorld;
    }

    public function getSpectatorSpawnPosition(): Vector3 {
        return $this->spectatorSpawnPosition;
    }

    public function getMode(): Mode {
        return $this->mode;
    }

    public function getSlots(): int {
        return $this->slots;
    }

}