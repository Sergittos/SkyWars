<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\game;


use pocketmine\block\inventory\ChestInventory;
use pocketmine\Server;
use pocketmine\utils\Utils;
use pocketmine\world\World;
use sergittos\skywars\game\chest\GameChest;
use sergittos\skywars\game\map\Map;
use sergittos\skywars\game\stage\Stage;
use sergittos\skywars\game\stage\WaitingStage;
use sergittos\skywars\game\team\Team;
use sergittos\skywars\session\Session;
use function array_key_exists;
use function array_search;
use function in_array;
use function spl_object_id;

class Game {

    private int $id;

    private Map $map;
    private Stage $stage;
    private Difficulty $difficulty = Difficulty::NORMAL;

    private ?World $world = null;

    /** @var Team[] */
    private array $teams;

    /** @var GameChest[] */
    private array $openedChests = [];

    /** @var Session[] */
    private array $players = [];

    /** @var Session[] */
    private array $spectators = [];

    public function __construct(Map $map, int $id) {
        $this->map = $map;
        $this->id = $id;
        $this->teams = Utils::cloneObjectArray($map->getTeams());

        $this->setStage(new WaitingStage());
    }

    public function getId(): int {
        return $this->id;
    }

    public function getMap(): Map {
        return $this->map;
    }

    public function getStage(): Stage {
        return $this->stage;
    }

    public function getDifficulty(): Difficulty {
        return $this->difficulty;
    }

    public function getWorld(): ?World {
        return $this->world;
    }

    /**
     * @return GameChest[]
     */
    public function getOpenedChests(): array {
        return $this->openedChests;
    }

    /**
     * @return Team[]
     */
    public function getTeams(): array {
        return $this->teams;
    }

    /**
     * @return Session[]
     */
    public function getPlayers(): array {
        return $this->players;
    }

    /**
     * @return Session[]
     */
    public function getSpectators(): array {
        return $this->spectators;
    }

    /**
     * @return Session[]
     */
    public function getPlayersAndSpectators(): array {
        return array_merge($this->players, $this->spectators);
    }

    public function getPlayersCount(): int {
        return count($this->players);
    }

    private function isChestOpened(ChestInventory $inventory): bool {
        return array_key_exists(spl_object_id($inventory), $this->openedChests);
    }

    public function isPlaying(Session $session): bool {
        return in_array($session, $this->players, true);
    }

    public function isSpectator(Session $session): bool {
        return in_array($session, $this->spectators, true);
    }

    public function setStage(Stage $stage): void {
        $this->stage = $stage;
        $this->stage->start($this);
    }

    public function setDifficulty(Difficulty $difficulty): void {
        $this->difficulty = $difficulty;
    }

    public function openChest(ChestInventory $inventory): void {
        if(!$this->isChestOpened($inventory)) {
            $this->openedChests[spl_object_id($inventory)] = new GameChest($inventory);
        }
    }

    public function closeChest(ChestInventory $inventory): void {
        if($this->isChestOpened($inventory)) {
            $chest = $this->openedChests[$chestId = spl_object_id($inventory)];
            $chest->getFloatingTextParticle()->setInvisible();
            $chest->updateFloatingText();

            unset($this->openedChests[$chestId]);
        }
    }

    public function addPlayer(Session $session): void {
        $this->players[] = $session;

        $this->stage->onJoin($session);
    }

    public function removePlayer(Session $session): void {
        unset($this->players[array_search($session, $this->players, true)]);

        $this->stage->onQuit($session);
    }

    public function addSpectator(Session $session): void {
        $this->spectators[] = $session;
    }

    public function removeSpectator(Session $session): void {
        unset($this->spectators[array_search($session, $this->spectators, true)]);
    }

    public function broadcastMessage(string $message): void {
        foreach($this->getPlayersAndSpectators() as $session) {
            $session->message($message);
        }
    }

    public function unloadWorld(): void {
        if($this->world !== null) {
            Server::getInstance()->getWorldManager()->unloadWorld($this->world);

            $this->world = null;
        }
    }

}