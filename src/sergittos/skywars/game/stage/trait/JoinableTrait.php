<?php


namespace sergittos\skywars\game\stage\trait;


use sergittos\skywars\game\Game;
use sergittos\skywars\session\Session;

trait JoinableTrait {

    public function start(Game $game): void {
        $this->game = $game;
    }

    public function onJoin(Session $session): void {
        /*
        $this->game->broadcastMessage(
            "{GRAY}" . $session->getUsername() . " {YELLOW}has joined ({AQUA}" .
            $this->game->getPlayersCount() . "{YELLOW}/{AQUA}" . $this->game->getMap()->getMaxCapacity() . "{YELLOW})!"
        );
        */
    }

    public function onQuit(Session $session): void {
        $this->game->broadcastMessage("{GRAY}" . $session->getUsername() . " {YELLOW}has quit!");
    }

}