<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\achievement;


use pocketmine\utils\CloningRegistryTrait;
use sergittos\skywars\achievement\presets\ArcherChallenge;
use sergittos\skywars\achievement\presets\AttentionSeeking;
use sergittos\skywars\achievement\presets\Baller;
use sergittos\skywars\achievement\presets\ChallengeMaster;
use sergittos\skywars\achievement\presets\ChallengePro;
use sergittos\skywars\achievement\presets\CorruptionLord;
use sergittos\skywars\achievement\presets\Criminal;
use sergittos\skywars\achievement\presets\Enderdragon;
use sergittos\skywars\achievement\presets\EnderParty;
use sergittos\skywars\achievement\presets\FistOfFury;
use sergittos\skywars\achievement\presets\Gapple;
use sergittos\skywars\achievement\presets\GoingHam;
use sergittos\skywars\achievement\presets\GoneFishing;
use sergittos\skywars\achievement\presets\Gotcha;
use sergittos\skywars\achievement\presets\HalfHealthChallenge;
use sergittos\skywars\achievement\presets\HappyMeal;
use sergittos\skywars\achievement\presets\HastaLaVista;
use sergittos\skywars\achievement\presets\IsThisAPortalGame;
use sergittos\skywars\achievement\presets\Killstolen;
use sergittos\skywars\achievement\presets\KillStreak;
use sergittos\skywars\achievement\presets\KitConnoisseur;
use sergittos\skywars\achievement\presets\Legendary;
use sergittos\skywars\achievement\presets\LuckySouls;
use sergittos\skywars\achievement\presets\MaxPerk;
use sergittos\skywars\achievement\presets\MaxSoulWell;
use sergittos\skywars\achievement\presets\MegaNoChestChallenge;
use sergittos\skywars\achievement\presets\MegaWarrior;
use sergittos\skywars\achievement\presets\MobSpawner;
use sergittos\skywars\achievement\presets\Mythical;
use sergittos\skywars\achievement\presets\NickCage;
use sergittos\skywars\achievement\presets\NoBlockChallenge;
use sergittos\skywars\achievement\presets\NoChestChallenge;
use sergittos\skywars\achievement\presets\NowImEnchanted;
use sergittos\skywars\achievement\presets\Peacemaker;
use sergittos\skywars\achievement\presets\PlayingItSafe;
use sergittos\skywars\achievement\presets\RNG;
use sergittos\skywars\achievement\presets\RookieChallenge;
use sergittos\skywars\achievement\presets\ShinyStuff;
use sergittos\skywars\achievement\presets\Skewered;
use sergittos\skywars\achievement\presets\SlowAndSteadyWinsTheRace;
use sergittos\skywars\achievement\presets\Sniper;
use sergittos\skywars\achievement\presets\SoldYourSoul;
use sergittos\skywars\achievement\presets\SoloWarrior;
use sergittos\skywars\achievement\presets\SoMuchChoice;
use sergittos\skywars\achievement\presets\SpeedRunner;
use sergittos\skywars\achievement\presets\Teamwork;
use sergittos\skywars\achievement\presets\TeamworkMakesTheDreamWork;
use sergittos\skywars\achievement\presets\TheAngelJourney;
use sergittos\skywars\achievement\presets\TheSiege;
use sergittos\skywars\achievement\presets\ThreeTwoOneGo;
use sergittos\skywars\achievement\presets\TouchOfDeath;
use sergittos\skywars\achievement\presets\Trolololololol;
use sergittos\skywars\achievement\presets\TwoFastThreeFurious;
use sergittos\skywars\achievement\presets\UHCChallenge;
use sergittos\skywars\achievement\presets\UhOh;
use sergittos\skywars\achievement\presets\UltimateWarriorChallenge;
use sergittos\skywars\achievement\presets\WellWell;
use sergittos\skywars\achievement\presets\WhoNeedsTeammates;

/**
 * @method static TwoFastThreeFurious TWO_FAST_THREE_FURIOUS()
 * @method static ThreeTwoOneGo THREE_TWO_ONE_GO()
 * @method static ArcherChallenge ARCHER_CHALLENGE()
 * @method static AttentionSeeking ATTENTION_SEEKING()
 * @method static Baller BALLER()
 * @method static ChallengeMaster CHALLENGE_MASTER()
 * @method static ChallengePro CHALLENGE_PRO()
 * @method static CorruptionLord CORRUPTION_LORD()
 * @method static Criminal CRIMINAL()
 * @method static EnderParty ENDER_PARTY()
 * @method static Enderdragon ENDERDRAGON()
 * @method static FistOfFury FIST_OF_FURY()
 * @method static Gapple GAPPLE()
 * @method static GoingHam GOING_HAM()
 * @method static GoneFishing GONE_FISHING()
 * @method static Gotcha GOTCHA()
 * @method static HalfHealthChallenge HALF_HEALTH_CHALLENGE()
 * @method static HappyMeal HAPPY_MEAL()
 * @method static HastaLaVista HASTA_LA_VISTA()
 * @method static IsThisAPortalGame IS_THIS_A_PORTAL_GAME()
 * @method static KillStreak KILL_STREAK()
 * @method static Killstolen KILLSTOLEN()
 * @method static KitConnoisseur KIT_CONNOISSEUR()
 * @method static Legendary LEGENDARY()
 * @method static LuckySouls LUCKY_SOULS()
 * @method static MaxPerk MAX_PERK()
 * @method static MaxSoulWell MAX_SOUL_WELL()
 * @method static MegaWarrior MEGA_WARRIOR()
 * @method static MobSpawner MOB_SPAWNER()
 * @method static Mythical MYTHICAL()
 * @method static NickCage NICK_CAGE()
 * @method static NoBlockChallenge NO_BLOCK_CHALLENGE()
 * @method static MegaNoChestChallenge MEGA_NO_CHEST_CHALLENGE()
 * @method static NoChestChallenge NO_CHEST_CHALLENGE()
 * @method static NowImEnchanted NOW_IM_ENCHANTED()
 * @method static Peacemaker PEACEMAKER()
 * @method static PlayingItSafe PLAYING_IT_SAFE()
 * @method static RNG RNG()
 * @method static RookieChallenge ROOKIE_CHALLENGE()
 * @method static ShinyStuff SHINY_STUFF()
 * @method static Skewered SKEWERED()
 * @method static SlowAndSteadyWinsTheRace SLOW_AND_STEADY_WINS_THE_RACE()
 * @method static Sniper SNIPER()
 * @method static SoMuchChoice SO_MUCH_CHOICE()
 * @method static SoldYourSoul SOLD_YOUR_SOUL()
 * @method static SoloWarrior SOLO_WARRIOR()
 * @method static SpeedRunner SPEED_RUNNER()
 * @method static Teamwork TEAMWORK()
 * @method static TeamworkMakesTheDreamWork TEAMWORK_MAKES_THE_DREAM_WORK()
 * @method static TheAngelJourney THE_ANGEL_JOURNEY()
 * @method static TheSiege THE_SIEGE()
 * @method static TouchOfDeath TOUCH_OF_DEATH()
 * @method static Trolololololol TROLOLOLOLOLOL()
 * @method static UHCChallenge UHC_CHALLENGE()
 * @method static UhOh UH_OH()
 * @method static UltimateWarriorChallenge ULTIMATE_WARRIOR_CHALLENGE()
 * @method static WellWell WELL_WELL()
 * @method static WhoNeedsTeammates WHO_NEEDS_TEAMMATES()
 */
class AchievementRegistry {
    use CloningRegistryTrait;

    /**
     * @return Achievement[]
     */
    static public function getAll(): array {
        return self::_registryGetAll();
    }

    static protected function setup(): void {
        self::register("two_fast_three_furious", new TwoFastThreeFurious());
        self::register("three_two_one_go", new ThreeTwoOneGo());
        self::register("archer_challenge", new ArcherChallenge());
        self::register("attention_seeking", new AttentionSeeking());
        self::register("baller", new Baller());
        self::register("challenge_master", new ChallengeMaster());
        self::register("challenge_pro", new ChallengePro());
        self::register("corruption_lord", new CorruptionLord());
        self::register("criminal", new Criminal());
        self::register("ender_party", new EnderParty());
        self::register("enderdragon", new Enderdragon());
        self::register("fist_of_fury", new FistOfFury());
        self::register("gapple", new Gapple());
        self::register("going_ham", new GoingHam());
        self::register("gone_fishing", new GoneFishing());
        self::register("gotcha", new Gotcha());
        self::register("half_health_challenge", new HalfHealthChallenge());
        self::register("happy_meal", new HappyMeal());
        self::register("hasta_la_vista", new HastaLaVista());
        self::register("is_this_a_portal_game", new IsThisAPortalGame());
        self::register("kill_streak", new KillStreak());
        self::register("killstolen", new Killstolen());
        self::register("kit_connoisseur", new KitConnoisseur());
        self::register("legendary", new Legendary());
        self::register("lucky_souls", new LuckySouls());
        self::register("max_perk", new MaxPerk());
        self::register("max_soul_well", new MaxSoulWell());
        self::register("mega_warrior", new MegaWarrior());
        self::register("mob_spawner", new MobSpawner());
        self::register("mythical", new Mythical());
        self::register("nick_cage", new NickCage());
        self::register("no_block_challenge", new NoBlockChallenge());
        self::register("mega_no_chest_challenge", new MegaNoChestChallenge());
        self::register("no_chest_challenge", new NoChestChallenge());
        self::register("now_im_enchanted", new NowImEnchanted());
        self::register("peacemaker", new Peacemaker());
        self::register("playing_it_safe", new PlayingItSafe());
        self::register("rng", new RNG());
        self::register("rookie_challenge", new RookieChallenge());
        self::register("shiny_stuff", new ShinyStuff());
        self::register("skewered", new Skewered());
        self::register("slow_and_steady_wins_the_race", new SlowAndSteadyWinsTheRace());
        self::register("sniper", new Sniper());
        self::register("so_much_choice", new SoMuchChoice());
        self::register("sold_your_soul", new SoldYourSoul());
        self::register("solo_warrior", new SoloWarrior());
        self::register("speed_runner", new SpeedRunner());
        self::register("teamwork", new Teamwork());
        self::register("teamwork_makes_the_dream_work", new TeamworkMakesTheDreamWork());
        self::register("the_angel_journey", new TheAngelJourney());
        self::register("the_siege", new TheSiege());
        self::register("touch_of_death", new TouchOfDeath());
        self::register("trolololololol", new Trolololololol());
        self::register("uhc_challenge", new UHCChallenge());
        self::register("uh_oh", new UhOh());
        self::register("ultimate_warrior_challenge", new UltimateWarriorChallenge());
        self::register("well_well", new WellWell());
        self::register("who_needs_teammates", new WhoNeedsTeammates());
    }

    static private function register(string $name, Achievement $achievement): void {
        self::_registryRegister($name, $achievement);
    }

}