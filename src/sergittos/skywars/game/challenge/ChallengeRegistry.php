<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\game\challenge;


use pocketmine\utils\CloningRegistryTrait;
use sergittos\skywars\game\challenge\presets\Archer;
use sergittos\skywars\game\challenge\presets\HalfHealth;
use sergittos\skywars\game\challenge\presets\NoBlock;
use sergittos\skywars\game\challenge\presets\NoChest;
use sergittos\skywars\game\challenge\presets\Rookie;
use sergittos\skywars\game\challenge\presets\UHC;
use sergittos\skywars\game\challenge\presets\UltimateWarrior;

/**
 * @method static Archer ARCHER()
 * @method static HalfHealth HALF_HEALTH()
 * @method static NoBlock NO_BLOCK()
 * @method static NoChest NO_CHEST()
 * @method static Rookie ROOKIE()
 * @method static UHC UHC()
 * @method static UltimateWarrior ULTIMATE_WARRIOR()
 */
class ChallengeRegistry {
    use CloningRegistryTrait;

    /**
     * @return Challenge[]
     */
    static public function getAll(): array {
        return self::_registryGetAll();
    }

    static protected function setup(): void {
        self::register("archer", new Archer());
        self::register("half_health", new HalfHealth());
        self::register("no_block", new NoBlock());
        self::register("no_chest", new NoChest());
        self::register("rookie", new Rookie());
        self::register("uhc", new UHC());
        self::register("ultimate_warrior", new UltimateWarrior());
    }

    /**
     * @return Challenge
     */
    static public function fromName(string $name): object {
        foreach(self::getAll() as $challenge) {
            if($challenge->getName() === $name) {
                return $challenge;
            }
        }
        return self::_registryFromString($name);
    }

    static private function register(string $name, Challenge $cage): void {
        self::_registryRegister($name, $cage);
    }

}