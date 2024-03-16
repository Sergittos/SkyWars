<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\achievement;


abstract class Achievement {

    private string $name;
    private string $description;

    private int $rewardPoints;

    public function __construct(string $name, string $description, int $rewardPoints) {
        $this->name = $name;
        $this->description = $description;
        $this->rewardPoints = $rewardPoints;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getRewardPoints(): int {
        return $this->rewardPoints;
    }

    // TODO

}