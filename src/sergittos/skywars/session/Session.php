<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\session;


use pocketmine\network\mcpe\protocol\ClientboundPacket;
use pocketmine\player\Player;
use pocketmine\world\sound\Sound;
use sergittos\skywars\game\cage\Cage;
use sergittos\skywars\game\cage\CageRegistry;
use sergittos\skywars\game\Game;
use sergittos\skywars\game\kit\Kit;
use sergittos\skywars\game\kit\KitRegistry;
use sergittos\skywars\game\team\Team;
use sergittos\skywars\session\scoreboard\LobbyScoreboard;
use sergittos\skywars\session\scoreboard\Scoreboard;
use sergittos\skywars\utils\message\MessageContainer;

class Session {

    private Player $player;
    private Scoreboard $scoreboard;

    private ?Game $game = null;
    private ?Team $team = null;

    private Kit $selectedKit;
    private Cage $selectedCage;

    /** @var SessionKit[] */
    private array $kits = [];

    /** @var Cage[] */
    private array $cages = [];

    public function __construct(Player $player) {
        $this->player = $player;
        $this->scoreboard = new LobbyScoreboard($this);
        $this->selectedKit = KitRegistry::DEFAULT(); // TODO: Get this from the database
        $this->selectedCage = CageRegistry::DEFAULT(); // TODO: Get this from the database
    }

    public function getPlayer(): Player {
        return $this->player;
    }

    public function getUsername(): string {
        return $this->player->getName();
    }

    public function getGame(): ?Game {
        return $this->game;
    }

    public function getTeam(): ?Team {
        return $this->team;
    }

    public function getSelectedKit(): Kit {
        return $this->selectedKit;
    }

    public function getSelectedCage(): Cage {
        return $this->selectedCage;
    }

    /**
     * @return SessionKit[]
     */
    public function getKits(): array {
        return $this->kits;
    }

    /**
     * @return Cage[]
     */
    public function getCages(): array {
        return $this->cages;
    }

    public function hasGame(): bool {
        return $this->game !== null;
    }

    public function hasTeam(): bool {
        return $this->team !== null;
    }

    public function isConnected(): bool {
        return $this->player->isConnected();
    }

    public function isPlaying(): bool {
        return $this->hasGame() and $this->game->isPlaying($this);
    }

    public function isSpectator(): bool {
        return $this->hasGame() and $this->game->isSpectator($this);
    }

    public function updateScoreboard(): void {
        $this->scoreboard->show();
    }

    public function setScoreboard(Scoreboard $scoreboard): void {
        $this->scoreboard = $scoreboard;
    }

    public function setGame(?Game $game): void {
        $this->game = $game;
    }

    public function setTeam(?Team $team): void {
        $this->team = $team;
    }

    public function setSelectedKit(Kit $selectedKit): void {
        $this->selectedKit = $selectedKit;
    }

    public function setSelectedCage(Cage $selectedCage): void {
        $this->selectedCage = $selectedCage;
    }

    /**
     * @param SessionKit[] $kits
     */
    public function setKits(array $kits): void {
        $this->kits = $kits;
    }

    /**
     * @param Cage[] $cages
     */
    public function setCages(array $cages): void {
        $this->cages = $cages;
    }

    public function addKit(SessionKit $kit): void {
        $this->kits[] = $kit;
    }

    public function addCage(Cage $cage): void {
        $this->cages[] = $cage;
    }

    public function assignTeam(): void {
        foreach($this->game->getTeams() as $team) {
            if(!$team->isFull()) {
                $team->addMember($this);
                return;
            }
        }
    }


    public function clearInventories(): void {
        $this->player->getCursorInventory()->clearAll();
        $this->player->getOffHandInventory()->clearAll();
        $this->player->getArmorInventory()->clearAll();
        $this->player->getInventory()->clearAll();
    }

    public function giveWaitingItems(): void {
        $this->clearInventories();

        // TODO
    }

    public function playSound(Sound $sound): void {
        $this->player->broadcastSound($sound, [$this->player]);
    }

    public function sendDataPacket(ClientboundPacket $packet): void {
        $this->player->getNetworkSession()->sendDataPacket($packet);
    }

    public function sendTitle(MessageContainer $title, ?MessageContainer $subtitle = null, int $fadeIn = -1, int $stay = -1, int $fadeOut = -1): void {
        $this->player->sendTitle($title->getMessage(), $subtitle !== null ? $subtitle->getMessage() : "", $fadeIn, $stay, $fadeOut);
    }

    public function sendActionBar(MessageContainer $container): void {
        $this->player->sendActionBarMessage($container->getMessage());
    }

    public function sendPopup(MessageContainer $container): void {
        $this->player->sendPopup($container->getMessage());
    }

    public function sendMessage(MessageContainer $container): void {
        $this->player->sendMessage($container->getMessage());
    }

}