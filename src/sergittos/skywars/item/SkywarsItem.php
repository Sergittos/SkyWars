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
use pocketmine\utils\TextFormat;
use sergittos\skywars\session\Session;
use sergittos\skywars\utils\message\MessageContainer;

abstract class SkywarsItem {

    private string $id;
    private string $name;

    public function __construct(string $id, MessageContainer $name) {
        $this->id = $id;
        $this->name = $name->getMessage();
    }

    public function asItem(): Item {
        $item = $this->realItem();
        $item->setCustomName($this->name);
        $item->getNamedTag()->setString("skywars", $this->id);
        return $item;
    }

    abstract public function canBeInteracted(Session $session): bool;

    abstract public function onInteract(Session $session): void;

    abstract protected function realItem(): Item;

}