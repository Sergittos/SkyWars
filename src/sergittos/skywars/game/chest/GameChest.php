<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\game\chest;


use pocketmine\block\inventory\ChestInventory;
use pocketmine\utils\TextFormat;
use pocketmine\world\particle\FloatingTextParticle;
use sergittos\skywars\game\Game;
use sergittos\skywars\utils\ConfigGetter;
use sergittos\skywars\utils\InventoryUtils;
use function gmdate;

class GameChest {

    private ChestInventory $inventory;
    private FloatingTextParticle $floatingTextParticle;

    private int $time;

    public function __construct(ChestInventory $inventory) {
        $this->inventory = $inventory;
        $this->floatingTextParticle = new FloatingTextParticle("");
        $this->time = ConfigGetter::getChestRefillDelay();
        $this->updateFloatingText();

        InventoryUtils::fillChest($inventory);
    }

    public function getInventory(): ChestInventory {
        return $this->inventory;
    }

    public function getFloatingTextParticle(): FloatingTextParticle {
        return $this->floatingTextParticle;
    }

    public function attemptToRefill(Game $game): void {
        $this->time--;

        if($this->time <= 0) {
            $this->refill($game);
        }
        $this->updateFloatingText();
    }

    private function refill(Game $game): void {
        InventoryUtils::fillChest($this->inventory);

        $game->closeChest($this->inventory);

        $this->floatingTextParticle->setInvisible();
    }

    public function updateFloatingText(): void {
        $this->floatingTextParticle->setText(TextFormat::YELLOW . gmdate("i:s", $this->time));

        $position = $this->inventory->getHolder();
        $position->getWorld()->addParticle($position->add(0.5, 1, 0.5), $this->floatingTextParticle);
    }

}