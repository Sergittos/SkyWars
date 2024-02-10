<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\game\event;


use sergittos\skywars\game\Game;

abstract class Event {

    protected Game $game;

    protected string $name;

    private int $duration;
    private int $startTime;

    public function __construct(string $name, float|int $duration) {
        $this->name = $name;
        $this->duration = (int) ($duration * 60);
    }

    public function getName(): string {
        return $this->name;
    }

    private function getTimeElapsed(): int {
        return time() - $this->startTime;
    }

    public function getTimeRemaining(): int {
        return $this->duration - $this->getTimeElapsed();
    }

    public function hasEnded(): bool {
        if($this->getTimeElapsed() >= $this->duration) {
            $this->end();
            return true;
        }
        return false;
    }

    public function start(Game $game): void {
        $this->game = $game;
        $this->startTime = time();
    }

    abstract protected function end(): void;

    abstract public function getNextEvent(): ?Event;

}