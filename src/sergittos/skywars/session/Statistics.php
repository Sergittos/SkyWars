<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\session;


use sergittos\skywars\achievement\Achievement;
use sergittos\skywars\game\map\Mode;

class Statistics {

    private int $coins = 0;
    private int $souls = 0;
    private int $tokens = 0;
    private int $achievementPoints = 0;

    /** @var int[] */
    private array $kills = [];

    /** @var int[] */
    private array $wins = [];

    /** @var Achievement[] */
    private array $achievements = [];

    public function getCoins(): int {
        return $this->coins;
    }

    public function getSouls(): int {
        return $this->souls;
    }

    public function getTokens(): int {
        return $this->tokens;
    }

    public function getAchievementPoints(): int {
        return $this->achievementPoints;
    }

    public function getKills(?Mode $mode): int {
        return $this->kills[$mode->value ?? "game"] ?? 0;
    }

    public function getWins(Mode $mode): int {
        return $this->wins[$mode->value] ?? 0;
    }

    /**
     * @return Achievement[]
     */
    public function getAchievements(): array {
        return $this->achievements;
    }

    public function setCoins(int $coins): void {
        $this->coins = $coins;
    }

    public function setSouls(int $souls): void {
        $this->souls = $souls;
    }

    public function setTokens(int $tokens): void {
        $this->tokens = $tokens;
    }

    public function setAchievementPoints(int $achievementPoints): void {
        $this->achievementPoints = $achievementPoints;
    }

    public function setKills(?Mode $mode, int $kills): void {
        $this->kills[$mode->value ?? "game"] = $kills;
    }

    public function setWins(Mode $mode, int $wins): void {
        $this->wins[$mode->value] = $wins;
    }

    /**
     * @param Achievement[] $achievements
     */
    public function setAchievements(array $achievements): void {
        $this->achievements = $achievements;
    }

    public function resetKills(): void {
        $this->kills["game"] = 0;
    }

}