<?php


namespace i3rain\FallDamage;

use i3rain\FallDamage\Main;
use pocketmine\event\Listener;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\Player;

class DamageEvent implements Listener{

    public function onEnable(){
        Main::getMain()->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onFallDamage(EntityDamageEvent $event){
        $entity = $event->getEntity();
        $damage = $event->getCause();
        if($entity instanceof Player){
            if($entity->hasPermission("nofalldamage")){
                if($damage == EntityDamageEvent::CAUSE_FALL){
                    $event->setCancelled(true);
                }
            }
        }
    }
}