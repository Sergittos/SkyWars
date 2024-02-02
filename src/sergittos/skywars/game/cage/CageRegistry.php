<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\game\cage;


use pocketmine\utils\CloningRegistryTrait;
use sergittos\skywars\game\cage\presets\Angel;
use sergittos\skywars\game\cage\presets\Banana;
use sergittos\skywars\game\cage\presets\Blue;
use sergittos\skywars\game\cage\presets\Bubblegum;
use sergittos\skywars\game\cage\presets\Cloud;
use sergittos\skywars\game\cage\presets\Dark;
use sergittos\skywars\game\cage\presets\DefaultCage;
use sergittos\skywars\game\cage\presets\Green;
use sergittos\skywars\game\cage\presets\Ice;
use sergittos\skywars\game\cage\presets\Lime;
use sergittos\skywars\game\cage\presets\MagicBox;
use sergittos\skywars\game\cage\presets\Mist;
use sergittos\skywars\game\cage\presets\Nicolas;
use sergittos\skywars\game\cage\presets\Orange;
use sergittos\skywars\game\cage\presets\Premium;
use sergittos\skywars\game\cage\presets\Privacy;
use sergittos\skywars\game\cage\presets\Rage;
use sergittos\skywars\game\cage\presets\Royal;
use sergittos\skywars\game\cage\presets\Sky;
use sergittos\skywars\game\cage\presets\Slime;
use sergittos\skywars\game\cage\presets\Toffee;
use sergittos\skywars\game\cage\presets\Tree;
use sergittos\skywars\game\cage\presets\VoidCage;

/**
 * @method static Angel ANGEL()
 * @method static Banana BANANA()
 * @method static Blue BLUE()
 * @method static Bubblegum BUBBLEGUM()
 * @method static Cloud CLOUD()
 * @method static Dark DARK()
 * @method static DefaultCage DEFAULT()
 * @method static Green GREEN()
 * @method static Ice ICE()
 * @method static Lime LIME()
 * @method static MagicBox MAGIC_BOX()
 * @method static Mist MIST()
 * @method static Nicolas NICOLAS()
 * @method static Orange ORANGE()
 * @method static Premium PREMIUM()
 * @method static Privacy PRIVACY()
 * @method static Rage RAGE()
 * @method static Royal ROYAL()
 * @method static Sky SKY()
 * @method static Slime SLIME()
 * @method static Toffee TOFFEE()
 * @method static Tree TREE()
 * @method static VoidCage VOID()
 */
class CageRegistry {
    use CloningRegistryTrait;

    /**
     * @return Cage[]
     */
    static public function getAll(): array {
        return self::_registryGetAll();
    }

    static protected function setup(): void {
        self::register("angel", new Angel());
        self::register("banana", new Banana());
        self::register("blue", new Blue());
        self::register("bubblegum", new Bubblegum());
        self::register("cloud", new Cloud());
        self::register("dark", new Dark());
        self::register("default", new DefaultCage());
        self::register("green", new Green());
        self::register("ice", new Ice());
        self::register("lime", new Lime());
        self::register("magic_box", new MagicBox());
        self::register("mist", new Mist());
        self::register("nicolas", new Nicolas());
        self::register("orange", new Orange());
        self::register("premium", new Premium());
        self::register("privacy", new Privacy());
        self::register("rage", new Rage());
        self::register("royal", new Royal());
        self::register("sky", new Sky());
        self::register("slime", new Slime());
        self::register("toffee", new Toffee());
        self::register("tree", new Tree());
        self::register("void", new VoidCage());
    }

    static private function register(string $name, Cage $cage): void {
        self::_registryRegister($name, $cage);
    }

}