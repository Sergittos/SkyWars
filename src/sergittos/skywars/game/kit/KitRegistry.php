<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\game\kit;


use pocketmine\utils\CloningRegistryTrait;
use sergittos\skywars\game\kit\presets\Armorer;
use sergittos\skywars\game\kit\presets\Armorsmith;
use sergittos\skywars\game\kit\presets\BaseballPlayer;
use sergittos\skywars\game\kit\presets\Batguy;
use sergittos\skywars\game\kit\presets\Cactus;
use sergittos\skywars\game\kit\presets\Cannoneer;
use sergittos\skywars\game\kit\presets\DefaultKit;

/**
 * @method static Armorer ARMORER()
 * @method static Armorsmith ARMORSMITH()
 * @method static BaseballPlayer BASEBALL_PLAYER()
 * @method static Batguy BATGUY()
 * @method static Cactus CACTUS()
 * @method static Cannoneer CANNONEER()
 * @method static DefaultKit DEFAULT()
 */
class KitRegistry {
    use CloningRegistryTrait;

    /**
     * @return Kit[]
     */
    static public function getAll(): array {
        return self::_registryGetAll();
    }

    static protected function setup(): void {
        self::register("armorer", new Armorer());
        self::register("armorsmith", new Armorsmith());
        self::register("baseball_player", new BaseballPlayer());
        self::register("batguy", new Batguy());
        self::register("cactus", new Cactus());
        self::register("cannoneer", new Cannoneer());
        self::register("default", new DefaultKit());
    }

    static private function register(string $name, Kit $kit): void {
        self::_registryRegister($name, $kit);
    }

}