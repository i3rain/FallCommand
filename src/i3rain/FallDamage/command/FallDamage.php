<?php


namespace i3rain\FallDamage\command;


use i3rain\FallDamage\Main;
use pocketmine\command\PluginCommand;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\plugin\Plugin;
use pocketmine\Player;

class FallDamage extends PluginCommand{

    public function __construct() {
        parent::__construct("nofall", Main::getMain());
        $this->setDescription("Schalte den Fallschaden an oder aus");
        $this->setPermission("nofall.command");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if(!$sender instanceof Player){
            $sender->sendMessage(Main::PREFIX."§c Benutze den Befehl im Spiel.");
            return false;
        }
        if(!$sender->hasPermission($this->getPermission())){
            $sender->sendMessage(Main::PREFIX."§c Du hast keine Berechtigung");
            return false;
        }
        if(!isset($args[0])){
            $sender->sendMessage(Main::PREFIX."§c Benutze: §/nofall <on/off>");
            return false;
        }

        if($args[0] === "on"){
            if(!$sender->hasPermission("nofalldamage")){
            $player = $sender->getName();
                Main::getMain()->getServer()->dispatchCommand(new ConsoleCommandSender(), "setuperm ".$player." nofalldamage");
                $sender->sendMessage(Main::PREFIX." Du bekommst kein Fallschaden mehr.");
                return true;
            }else{
            $sender->sendMessage(Main::PREFIX." Du hast dies schon Aktiviert.");
            return true;
            }
        }

        if($args[0] === "off"){
            if($sender->hasPermission("nofalldamage")){
            $player = $sender->getName();
                Main::getMain()->getServer()->dispatchCommand(new ConsoleCommandSender(), "unsetuperm ".$player." nofalldamage");
                $sender->sendMessage(Main::PREFIX." Du bekommst wieder Fallschaden.");
                return true;
            }else{
            $sender->sendMessage(Main::PREFIX." Du hast dies schon Deaktiviert.");
            return true;
            }
        }
        $sender->sendMessage(Main::PREFIX."§c Benutze: §/nofall <on/off>");
        return true;
    }
}
