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

trait MapProperties {

    protected string $name;

    protected Vector3 $spectatorSpawnPoint;
    protected Mode $mode;

    protected int $slots;

    public function getName(): string {
        return $this->name;
    }

    public function getSpectatorSpawnPoint(): Vector3 {
        return $this->spectatorSpawnPoint;
    }

    public function getMode(): Mode {
        return $this->mode;
    }

    public function getSlots(): int {
        return $this->slots;
    }

}