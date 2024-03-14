<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\session;


use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\network\mcpe\protocol\ClientboundPacket;
use pocketmine\player\GameMode;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\world\sound\Sound;
use sergittos\skywars\game\cage\Cage;
use sergittos\skywars\game\cage\CageRegistry;
use sergittos\skywars\game\challenge\Challenge;
use sergittos\skywars\game\Game;
use sergittos\skywars\game\kit\Kit;
use sergittos\skywars\game\kit\KitRegistry;
use sergittos\skywars\game\stage\EndingStage;
use sergittos\skywars\game\team\Team;
use sergittos\skywars\item\SkywarsItemRegistry;
use sergittos\skywars\session\scoreboard\layout\Layout;
use sergittos\skywars\session\scoreboard\layout\LobbyLayout;
use sergittos\skywars\session\scoreboard\Scoreboard;
use sergittos\skywars\utils\message\MessageContainer;
use function strcmp;
use function usort;

class Session {

    private Player $player;

    private Scoreboard $scoreboard;
    private Statistics $statistics;

    private ?Game $game = null;
    private ?Team $team = null;

    private ?Session $lastSessionHit = null;
    private ?Session $trackingSession = null;

    private Kit $selectedKit;
    private Cage $selectedCage;

    /** @var Challenge[] */
    private array $selectedChallenges = [];

    /** @var SessionKit[] */
    private array $kits = [];

    /** @var Cage[] */
    private array $cages = [];

    public function __construct(Player $player) {
        $this->player = $player;
        $this->scoreboard = new Scoreboard($this);

        $this->statistics = new Statistics(); // TODO: Get this from the database
        $this->selectedKit = KitRegistry::DEFAULT(); // TODO: Get this from the database
        $this->selectedCage = CageRegistry::DEFAULT(); // TODO: Get this from the database
    }

    public function getPlayer(): Player {
        return $this->player;
    }

    public function getUsername(): string {
        return $this->player->getName();
    }

    public function getColoredUsername(): string {
        $username = $this->getUsername();
        if($this->hasTeam()) {
            return $this->team->getColor() . $username;
        }
        return $username;
    }

    public function getStatistics(): Statistics {
        return $this->statistics;
    }

    public function getGame(): ?Game {
        return $this->game;
    }

    public function getTeam(): ?Team {
        return $this->team;
    }

    public function getLastSessionHit(): ?Session {
        return $this->lastSessionHit;
    }

    public function getTrackingSession(): ?Session {
        return $this->trackingSession;
    }

    public function getSelectedKit(): Kit {
        return $this->selectedKit;
    }

    public function getSelectedCage(): Cage {
        return $this->selectedCage;
    }

    /**
     * @return Challenge[]
     */
    public function getSelectedChallenges(): array {
        usort($this->selectedChallenges, function(Challenge $a, Challenge $b) {
            return strcmp($a->getName(), $b->getName());
        });
        return $this->selectedChallenges;
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

    public function hasSelectedChallenge(Challenge $challenge): bool {
        foreach($this->selectedChallenges as $selectedChallenge) {
            if($selectedChallenge->getName() === $challenge->getName()) {
                return true;
            }
        }
        return false;
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

    public function setScoreboardLayout(Layout $layout): void {
        $this->scoreboard->setLayout($layout);
    }

    public function setGame(?Game $game): void {
        $this->game = $game;
    }

    public function setTeam(?Team $team): void {
        $this->team = $team;
    }

    public function setLastSessionHit(?Session $lastSessionHit): void {
        $this->lastSessionHit = $lastSessionHit;
    }

    public function setTrackingSession(?Session $trackingSession): void {
        $this->trackingSession = $trackingSession;
        $this->updateCompassDirection();
    }

    public function setSelectedKit(Kit $selectedKit): void {
        $this->selectedKit = $selectedKit;
    }

    public function setSelectedCage(Cage $selectedCage): void {
        $this->selectedCage = $selectedCage;
    }

    /**
     * @param Challenge[] $selectedChallenges
     */
    public function setSelectedChallenges(array $selectedChallenges): void {
        $this->selectedChallenges = $selectedChallenges;
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

    public function addSelectedChallenge(Challenge $challenge): void {
        $this->selectedChallenges[] = $challenge;
    }

    public function removeSelectedChallenge(Challenge $challenge): void {
        $this->selectedChallenges = array_filter($this->selectedChallenges, function(Challenge $selectedChallenge) use ($challenge): bool {
            return $selectedChallenge->getName() !== $challenge->getName();
        });
    }

    public function addKit(SessionKit $kit): void {
        $this->kits[] = $kit;
    }

    public function addCage(Cage $cage): void {
        $this->cages[] = $cage;
    }

    public function updateScoreboard(): void {
        $this->scoreboard->update();
    }

    public function updateCompassDirection(): void {
        $this->player->getNetworkSession()->syncWorldSpawnPoint(
            $this->trackingSession !== null ? $this->trackingSession->getPlayer()->getPosition() : $this->player->getWorld()->getSpawnLocation()
        );
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

        $inventory = $this->player->getInventory();
        $inventory->setItem(0, SkywarsItemRegistry::KIT_SELECTOR());
        $inventory->setItem(7, SkywarsItemRegistry::SKYWARS_CHALLENGES());
        $inventory->setItem(8, SkywarsItemRegistry::LEAVE_GAME());
    }

    public function giveSpectatorItems(): void {
        $this->clearInventories();

        $inventory = $this->player->getInventory();
        $inventory->setItem(0, SkywarsItemRegistry::TELEPORTER());
        $inventory->setItem(4, SkywarsItemRegistry::SPECTATOR_SETTINGS());
        $inventory->setItem(7, SkywarsItemRegistry::PLAY_AGAIN());
        $inventory->setItem(8, SkywarsItemRegistry::RETURN_TO_LOBBY());
    }

    public function teleportToHub(): void {
        $this->player->getEffects()->clear();
        $this->player->setGamemode(GameMode::ADVENTURE());
        $this->player->setHealth($this->player->getMaxHealth());
        $this->player->setNameTag($this->player->getDisplayName());
        $this->player->teleport(Server::getInstance()->getWorldManager()->getDefaultWorld()->getSafeSpawn());

        $this->clearInventories();
        $this->setSelectedChallenges([]);
        $this->setTrackingSession(null);
        $this->setScoreboardLayout(new LobbyLayout());
    }

    public function kill(int $cause): void {
        $killerSession = $this->getLastSessionHit();
        $username = $this->getColoredUsername();

        if($killerSession !== null) {
            // TODO: Add coins to the killer

            $arguments = [
                "player" => $username,
                "killer" => $killerSession->getColoredUsername()
            ];

            if($cause === EntityDamageEvent::CAUSE_VOID) {
                $this->game->broadcastMessage(new MessageContainer("PLAYER_WAS_KNOCKED_INTO_THE_VOID", $arguments));
            } else {
                $this->game->broadcastMessage(new MessageContainer("PLAYER_WAS_KILLED_BY_PLAYER", $arguments));
            }
        }

        if($cause === EntityDamageEvent::CAUSE_VOID and $killerSession === null) {
            $this->game->broadcastMessage(new MessageContainer("PLAYER_FELL_TO_THE_VOID", [
                "player" => $username
            ]));
        }

        $this->game->broadcastActionBar(new MessageContainer("PLAYERS_REMAINING", [
            "count" => $this->game->getPlayersCount()
        ]));

        $this->player->getEffects()->clear();
        $this->player->teleport($this->game->getMap()->getSpectatorSpawnPoint());
        $this->player->setGamemode(GameMode::SPECTATOR);

        if(!$this->game->getStage() instanceof EndingStage) {
            $this->game->removePlayer($this, false, true);

            $this->sendTitle(new MessageContainer("YOU_DIED_TITLE"), new MessageContainer("YOU_DIED_SUBTITLE"), 0, 100, 0);
        } else {
            $this->clearInventories();
        }
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