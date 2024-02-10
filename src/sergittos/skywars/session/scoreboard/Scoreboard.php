<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\session\scoreboard;


use pocketmine\network\mcpe\protocol\RemoveObjectivePacket;
use pocketmine\network\mcpe\protocol\SetDisplayObjectivePacket;
use pocketmine\network\mcpe\protocol\SetScorePacket;
use pocketmine\network\mcpe\protocol\types\ScorePacketEntry;
use sergittos\skywars\session\scoreboard\layout\Layout;
use sergittos\skywars\session\Session;
use sergittos\skywars\utils\ColorUtils;
use sergittos\skywars\utils\message\MessageContainer;
use function count;

class Scoreboard {

    private Session $session;
    private Layout $layout;

    public function __construct(Session $session) {
        $this->session = $session;
    }

    public function setLayout(Layout $layout): void {
        $this->layout = $layout;
        $this->update();
    }

    public function update(): void {
        $this->hide();
        $this->display();
        $this->displayMessages();
    }

    private function hide(): void {
        $packet = new RemoveObjectivePacket();
        $packet->objectiveName = $this->session->getUsername();
        $this->session->sendDataPacket($packet);
    }

    private function display(): void {
        $packet = new SetDisplayObjectivePacket();
        $packet->displaySlot = SetDisplayObjectivePacket::DISPLAY_SLOT_SIDEBAR;
        $packet->objectiveName = $this->session->getUsername();
        $packet->displayName = (new MessageContainer("SCOREBOARD_TITLE"))->getMessage();
        $packet->criteriaName = "dummy";
        $packet->sortOrder = SetDisplayObjectivePacket::SORT_ORDER_DESCENDING;
        $this->session->sendDataPacket($packet);
    }

    private function displayMessages(): void {
        $messages = $this->layout->getMessageContainer($this->session)->getMessage();
        foreach($messages as $index => $message) {
            $this->setLine(count($messages) - $index, $message);
        }
    }

    private function setLine(int $score, string $text): void {
        $entry = new ScorePacketEntry();
        $entry->objectiveName = $this->session->getUsername();
        $entry->type = ScorePacketEntry::TYPE_FAKE_PLAYER;
        $entry->customName = ColorUtils::translate($text);
        $entry->score = $score;
        $entry->scoreboardId = $score;
        $packet = new SetScorePacket();
        $packet->type = SetScorePacket::TYPE_CHANGE;
        $packet->entries[] = $entry;
        $this->session->sendDataPacket($packet);
    }

}