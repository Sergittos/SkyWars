<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\item\game;


use muqsit\invmenu\InvMenu;
use muqsit\invmenu\transaction\DeterministicInvMenuTransaction;
use muqsit\invmenu\type\InvMenuTypeIds;
use pocketmine\block\utils\DyeColor;
use pocketmine\block\VanillaBlocks;
use pocketmine\inventory\Inventory;
use pocketmine\item\Item;
use pocketmine\item\VanillaItems;
use sergittos\skywars\game\challenge\GameChallenge;
use sergittos\skywars\game\challenge\GameChallengeRegistry;
use sergittos\skywars\session\Session;
use sergittos\skywars\session\SessionFactory;
use sergittos\skywars\utils\ItemInfo;
use sergittos\skywars\utils\message\MessageContainer;

class SkywarsChallengesItem extends GameItem {

    public function __construct() {
        parent::__construct("skywars_challenges", new MessageContainer("SKYWARS_CHALLENGES"));
    }

    public function onInteract(Session $session): void {
        $menu = InvMenu::create(InvMenuTypeIds::TYPE_DOUBLE_CHEST);
        $menu->setName("SkyWars Challenges");

        $inventory = $menu->getInventory();
        for($i = 0; $i < $inventory->getSize(); $i++) {
            $inventory->setItem($i, VanillaBlocks::STAINED_GLASS_PANE()->setColor(DyeColor::BLACK)->asItem());
        }

        foreach(GameChallengeRegistry::getAll() as $challenge) {
            $this->setChallengeItem($challenge, $session, $inventory);
        }

        $menu->setListener(InvMenu::readonly(function(DeterministicInvMenuTransaction $transaction) {
            $session = SessionFactory::getSession($transaction->getPlayer());
            if(!$session->isPlaying()) {
                return;
            }

            $name = $transaction->getItemClicked()->getNamedTag()->getTag("skywars_challenge")?->getValue();
            if($name === null) {
                return;
            }

            $challenge = GameChallengeRegistry::fromName($name);

            if(!$session->hasSelectedChallenge($challenge)) {
                $session->addSelectedChallenge($challenge);
                $session->sendMessage(new MessageContainer("CHALLENGE_ACTIVATED", [
                    "challenge" => $challenge->getName()
                ]));
            } else {
                $session->removeSelectedChallenge($challenge);
                $session->sendMessage(new MessageContainer("CHALLENGE_DEACTIVATED", [
                    "challenge" => $challenge->getName()
                ]));
            }

            $this->setChallengeItem($challenge, $session, $transaction->getAction()->getInventory());
        }));

        $menu->send($session->getPlayer());
    }

    protected function realItem(): Item {
        return VanillaItems::BLAZE_POWDER();
    }

    private function setChallengeItem(GameChallenge $challenge, Session $session, Inventory $inventory): void {
        $challengeItemInfo = $challenge->getItemInfo();
        $dyeItemInfo = new ItemInfo($challengeItemInfo->getSlot() + 9, VanillaItems::DYE());

        $inventory->setItem($challengeItemInfo->getSlot(), $challengeItemInfo->getItem($session, $challenge));
        $inventory->setItem($dyeItemInfo->getSlot(), $dyeItemInfo->getItem($session, $challenge));
    }

}