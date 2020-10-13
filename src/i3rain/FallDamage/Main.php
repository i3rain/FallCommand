<?php


namespace i3rain\FallDamage;

use i3rain\FallDamage\command\FallDamage;
use i3rain\FallDamage\DamageEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\command\SimpleCommandMap;
use pocketmine\Player;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener {

    const PREFIX = "§6[FallDamage] §r§f: ";

    public static $Main;

    public function onEnable(): void
    {
        self::$Main = $this;
        $this->getServer()->getPluginManager()->registerEvents(new DamageEvent(), $this);
        $this->getServer()->getCommandMap()->register("Main", new FallDamage());
        $config = new Config($this->getDataFolder()."config.yml", Config::YAML);
        $this->saveResource("config.yml");
    }

    public static function getMain(): self {
        return self::$Main;
    }
}
