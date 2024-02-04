<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\game\chest;


use pocketmine\utils\TextFormat;
use pocketmine\world\particle\FloatingTextParticle;
use sergittos\skywars\game\Game;
use sergittos\skywars\utils\ConfigGetter;
use sergittos\skywars\utils\InventoryUtils;
use function count;
use function gmdate;

class GameChest { // I should clean this class

    private ChestInventory $inventory;

    private FloatingTextParticle $floatingTextParticle;
    private FloatingTextParticle $isEmptyFloatingTextParticle;

    private int $time;

    public function __construct(ChestInventory $inventory) {
        $this->inventory = $inventory;
        $this->floatingTextParticle = new FloatingTextParticle("");
        $this->isEmptyFloatingTextParticle = new FloatingTextParticle(TextFormat::RED . "Empty!");
        $this->time = ConfigGetter::getChestRefillDelay();
        $this->updateFloatingText();

        InventoryUtils::fillChest($inventory);
    }

    public function attemptToRefill(Game $game): void {
        $this->time--;

        if($this->time <= 0) {
            $this->refill($game);
        }
        $this->updateFloatingText();
    }

    public function refill(Game $game): void {
        InventoryUtils::fillChest($this->inventory);

        $game->closeChest($this->inventory);

        $this->hideFloatingTexts();
        $this->inventory->setNeedsRefill(false);
    }

    public function updateFloatingText(): void {
        $this->floatingTextParticle->setText(TextFormat::YELLOW . gmdate("i:s", $this->time));
        $this->isEmptyFloatingTextParticle->setInvisible(count($this->inventory->getContents()) > 0);

        $position = $this->inventory->getHolder();
        $world = $position->getWorld();

        $world->addParticle($position->add(0.5, $this->isEmptyFloatingTextParticle->isInvisible() ? 1 : 1.25, 0.5), $this->floatingTextParticle);
        $world->addParticle($position->add(0.5, 0.75, 0.5), $this->isEmptyFloatingTextParticle);
    }

    public function hideFloatingTexts(): void {
        $this->floatingTextParticle->setInvisible();
        $this->isEmptyFloatingTextParticle->setInvisible();
    }

}