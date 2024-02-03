<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\game\team;


use pocketmine\block\utils\DyeColor;
use pocketmine\math\Vector3;
use sergittos\skywars\utils\ColorUtils;
use function strtoupper;

trait TeamProperties {

    protected string $name;

    protected Vector3 $spawnPoint;

    /**
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    public function getColor(): string {
        return ColorUtils::translate("{" . strtoupper($this->name) . "}");
    }

    public function getDyeColor(): DyeColor {
        return ColorUtils::getDyeColor($this->getColor());
    }

    public function getSpawnPoint(): Vector3 {
        return $this->spawnPoint;
    }

}