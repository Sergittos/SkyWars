<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\sergittos\skywars;


use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use sergittos\skywars\sergittos\skywars\listener\SessionListener;

class SkyWars extends PluginBase {

    protected function onEnable(): void {
        $this->registerListener(new SessionListener());
    }

    private function registerListener(Listener $listener): void {
        $this->getServer()->getPluginManager()->registerEvents($listener, $this);
    }

}