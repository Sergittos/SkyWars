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
use sergittos\skywars\game\team\Team;
use sergittos\skywars\SkyWars;
use function array_map;
use function json_decode;

class MapFactory {

    /** @var Map[] */
    static private array $maps = [];

    static public function init(): void {
        foreach(json_decode(file_get_contents(SkyWars::getInstance()->getDataFolder() . "maps.json"), true) as $data) {
            self::addMap(new Map(
                $data["name"],
                self::vectorFromArray($data["spectatorSpawnPoint"]),
                Mode::from($data["mode"]),
                $slots = $data["slots"],
                array_map(fn($data) => new Team($data["name"], self::vectorFromArray($data["spawnPoint"]), $slots), $data["teams"])
            ));
        }
    }

    /**
     * @return Map[]
     */
    static public function getMaps(): array {
        return self::$maps;
    }

    static public function getRandomMap(): ?Map {
        return self::$maps[array_rand(self::$maps)] ?? null;
    }

    static private function addMap(Map $map): void {
        self::$maps[$map->getName()] = $map;
    }

    static private function vectorFromArray(array $array): Vector3 {
        return new Vector3($array["x"], $array["y"], $array["z"]);
    }

}