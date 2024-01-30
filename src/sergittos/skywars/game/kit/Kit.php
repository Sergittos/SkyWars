<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\game\kit;


use pocketmine\item\Item;

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
    protected function getNormalContents(): array {
        return [];
    }

    /**
     * @return Item[]
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
     * @return Item[]
     */
    protected function getInsaneArmorContents(): array {
        return [];
    }

}