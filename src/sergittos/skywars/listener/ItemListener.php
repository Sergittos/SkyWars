<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\listener;


use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemUseEvent;
use pocketmine\item\Item;
use sergittos\skywars\item\SkywarsItemRegistry;
use sergittos\skywars\session\SessionFactory;

class ItemListener implements Listener {

    public function onTransaction(InventoryTransactionEvent $event): void {
        foreach($event->getTransaction()->getActions() as $action) {
            if($this->getSkywarsTag($action->getSourceItem()) !== null) {
                $event->cancel();
            }
        }
    }

    public function onUse(PlayerItemUseEvent $event): void {
        $tag = $this->getSkywarsTag($event->getItem());
        if($tag !== null) {
            SkywarsItemRegistry::fromName($tag)->onInteract(SessionFactory::getSession($event->getPlayer()));
        }
    }

    private function getSkywarsTag(Item $item): ?string {
        return $item->getNamedTag()->getTag("skywars")?->getValue();
    }

}