<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\item;


use pocketmine\item\Item;
use pocketmine\utils\CloningRegistryTrait;
use sergittos\skywars\item\game\KitSelectorItem;
use sergittos\skywars\item\game\LeaveGameItem;
use sergittos\skywars\item\game\SkywarsChallengesItem;
use sergittos\skywars\item\spectator\PlayAgainItem;
use sergittos\skywars\item\spectator\ReturnToLobbyItem;
use sergittos\skywars\item\spectator\SpectatorSettingsItem;
use sergittos\skywars\item\spectator\TeleporterItem;

/**
 * @method static Item KIT_SELECTOR()
 * @method static Item LEAVE_GAME()
 * @method static Item SKYWARS_CHALLENGES()
 * @method static Item PLAY_AGAIN()
 * @method static Item RETURN_TO_LOBBY()
 * @method static Item SPECTATOR_SETTINGS()
 * @method static Item TELEPORTER()
 */
class SkywarsItemRegistry {
    use CloningRegistryTrait {
        _registryFromString as fromString;
    }

    static protected function setup(): void {
        self::register("kit_selector", new KitSelectorItem());
        self::register("leave_game", new LeaveGameItem());
        self::register("skywars_challenges", new SkywarsChallengesItem());

        self::register("play_again", new PlayAgainItem());
        self::register("return_to_lobby", new ReturnToLobbyItem());
        self::register("spectator_settings", new SpectatorSettingsItem());
        self::register("teleporter", new TeleporterItem());
    }

    static public function fromId(string $id): object {
        return self::fromString($id);
    }

    static public function _registryFromString(string $name): Item {
        return self::fromString($name)->asItem();
    }

    static private function register(string $name, SkywarsItem $item): void {
        self::_registryRegister($name, $item);
    }

}