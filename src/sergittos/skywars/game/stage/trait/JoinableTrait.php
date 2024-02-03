<?php


namespace sergittos\skywars\game\stage\trait;


use pocketmine\player\GameMode;
use pocketmine\world\Position;
use sergittos\skywars\game\Game;
use sergittos\skywars\session\scoreboard\WaitingScoreboard;
use sergittos\skywars\session\Session;
use sergittos\skywars\utils\message\MessageContainer;

trait JoinableTrait {

    public function start(Game $game): void {
        $this->game = $game;
    }

    public function onJoin(Session $session): void {
        $session->setGame($this->game);
        $session->setScoreboard(new WaitingScoreboard($session));
        $session->assignTeam();
        $session->getSelectedCage()->build($position = Position::fromObject($session->getTeam()->getSpawnPoint(), $this->game->getWorld()));
        $session->giveWaitingItems();
        $session->sendTitle(new MessageContainer("GAME_JOIN_TITLE"), new MessageContainer("GAME_JOIN_SUBTITLE", [
            "mode" => $this->game->getDifficulty()->getDisplayName()
        ]), 25, 40, 25);

        $player = $session->getPlayer();
        $player->setGamemode(GameMode::ADVENTURE);
        $player->teleport($position);

        $this->game->broadcastMessage(new MessageContainer("PLAYER_JOINED", [
            "player" => $session->getUsername(),
            "count" => $this->game->getPlayersCount(),
            "slots" => $this->game->getMap()->getSlots()
        ]));
    }

    public function onQuit(Session $session): void {
        $session->getSelectedCage()->destroy($this->game->getWorld());
        $session->getTeam()->removeMember($session);

        $this->game->broadcastMessage(new MessageContainer("PLAYER_QUIT", [
            "player" => $session->getUsername()
        ]));
    }

    public function tick(): void {
        foreach($this->game->getPlayers() as $session) {
            $session->sendActionBar(new MessageContainer("SELECTED_KIT", [
                "kit" => $session->getSelectedKit()->getName()
            ]));
            $session->updateScoreboard();
        }
    }

}