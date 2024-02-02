<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\game\kit;


use pocketmine\item\Armor;
use pocketmine\item\Item;
use sergittos\skywars\game\Difficulty;
use sergittos\skywars\session\Session;
use function array_map;

abstract class Kit {

    private string $name;

    private Rarity $rarity;

    public function __construct(string $name, Rarity $rarity) {
        $this->name = $name;
        $this->rarity = $rarity;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getRarity(): Rarity {
        return $this->rarity;
    }

    /**
     * @return Item[]
     */
    public function getContents(Difficulty $difficulty): array {
        return match($difficulty) {
            Difficulty::NORMAL => $this->getNormalContents(),
            Difficulty::INSANE => $this->getInsaneContents()
        };
    }

    /**
     * @return Item[]
     */
    public function getArmorContents(Difficulty $difficulty): array {
        return match($difficulty) {
            Difficulty::NORMAL => $this->getNormalArmorContents(),
            Difficulty::INSANE => $this->getInsaneArmorContents()
        };
    }

    public function apply(Session $session): void {
        $player = $session->getPlayer();
        $difficulty = $session->getGame()->getDifficulty();

        $player->getInventory()->setContents($this->getContents($difficulty));
        $player->getArmorInventory()->setContents(array_map(function(Armor $armor) use ($session): Item {
            return $armor->setCustomColor($session->getTeam()->getDyeColor()->getRgbValue());
        }, $this->getArmorContents($difficulty)));

    }

    /**
     * @return Item[]
     */
    protected function getNormalContents(): array {
        return [];
    }

    /**
     * @return Armor[]
     */
    protected function getNormalArmorContents(): array {
        return [];
    }

    /**
     * @return Item[]
     */
    protected function getInsaneContents(): array {
        return [];
    }

    /**
     * @return Armor[]
     */
    protected function getInsaneArmorContents(): array {
        return [];
    }

}