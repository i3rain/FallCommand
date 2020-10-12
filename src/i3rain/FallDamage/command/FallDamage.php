<?php


namespace i3rain\FallDamage\command;


use i3rain\FallDamage\Main;
use pocketmine\command\PluginCommand;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\plugin\Plugin;
use pocketmine\Player;
use pocketmine\utils\Config;

class FallDamage extends PluginCommand{

    public function __construct() {
        parent::__construct("nofall", Main::getMain());
        $this->setDescription("Schalte den Fallschaden an oder aus");
        $this->setPermission("nofall.command");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        $config = new Config($this->getPlugin()->getDataFolder()."config.yml", Config::YAML);
        $config->save();
        if(!$sender instanceof Player){
            $sender->sendMessage(Main::PREFIX.$config->get("only-In-Game-message"));
            return false;
        }
        if(!$sender->hasPermission($this->getPermission())){
            $sender->sendMessage(Main::PREFIX.$config->get("noperms-messsage"));
            return false;
        }
        if(!isset($args[0])){
            $sender->sendMessage(Main::PREFIX.$config->get("usage-message"));
            return false;
        }

        if($args[0] === "on"){
            if(!$sender->hasPermission("nofalldamage")){
            $player = $sender->getName();
                Main::getMain()->getServer()->dispatchCommand(new ConsoleCommandSender(), "setuperm ".$player." nofalldamage");
                $sender->sendMessage(Main::PREFIX.$config->get("aktiv-message"));
                return true;
            }else{
            $sender->sendMessage(Main::PREFIX.$config->get("already-activated-message"));
            return true;
            }
        }

        if($args[0] === "off"){
            if($sender->hasPermission("nofalldamage")){
            $player = $sender->getName();
                Main::getMain()->getServer()->dispatchCommand(new ConsoleCommandSender(), "unsetuperm ".$player." nofalldamage");
                $sender->sendMessage(Main::PREFIX.$config->get("deactivated-message"));
                return true;
            }else{
            $sender->sendMessage(Main::PREFIX.$config->get("already-deactivated-message"));
            return true;
            }
        }
        $sender->sendMessage(Main::PREFIX.$config->get("usage-message"));
        return true;
    }
}
