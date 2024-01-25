<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\game;


use pocketmine\math\Vector3;
use pocketmine\Server;
use pocketmine\world\World;
use sergittos\skywars\game\map\Map;
use sergittos\skywars\game\stage\Stage;
use sergittos\skywars\game\stage\WaitingStage;
use sergittos\skywars\game\team\Team;
use sergittos\skywars\session\Session;

class Game {

    private int $id;

    private Map $map;
    private Stage $stage;

    private ?World $world = null;

    /** @var Team[] */
    private array $teams;

    /** @var Vector3[] */
    private array $blocks = [];

    /** @var Session[] */
    private array $players = [];

    /** @var Session[] */
    private array $spectators = [];

    public function __construct(Map $map, int $id) {
        $this->map = $map;
        $this->id = $id;
        // todo: add teams

        $this->setStage(new WaitingStage());
    }

    public function getId(): int {
        return $this->id;
    }

    public function getStage(): Stage {
        return $this->stage;
    }

    public function getMap(): Map {
        return $this->map;
    }

    public function getWorld(): ?World {
        return $this->world;
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

    public function checkBlock(Vector3 $position): bool {
        foreach($this->blocks as $index => $block) {
            if($block->equals($position)) {
                unset($this->blocks[$index]);
                return true;
            }
        }
        return false;
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

    public function addBlock(Vector3 $position): void {
        $this->blocks[] = $position;
    }

    public function addPlayer(Session $session): void {
        $this->players[] = $session;
    }

    public function removePlayer(Session $session): void {
        unset($this->players[array_search($session, $this->players, true)]);
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
            $this->blocks = [];
        }
    }

}