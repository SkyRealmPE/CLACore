<?php

namespace Events;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;

use pocketmine\Player;

use pocketmine\utils\Config;

use pocketmine\network\mcpe\protocol\LevelEventPacket;

use Tasks\GuardianTask;
use Tasks\TitleTask;

use pocketmine\utils\TextFormat as C;

use CLACore\Core;

class onJoinEvent implements Listener {

    private $core;
    
    public function __construct(Core $core){
        $this->core = $core;
    }

    public function onJoin(PlayerJoinEvent $e){
        $player = $e->getPlayer();
        $name = $player->getName();
        $core = $this->core;

        #Guardian
        $config = new Config($this->core->getDataFolder()."config.yml", Config::YAML);
        if($config->get("Allow-Guardian") == true){
            $core->getServer()->getScheduler()->scheduleDelayedTask(new GuardianTask($core, $player), 25);
        }

        /*$config = new Config($core->getDataFolder()."config.yml", Config::YAML);
        foreach ($config->get("Allowed-Devices") as $os){
            if ($os == $player->getDeviceOS()){
            }else{
                $player->kick(C::YELLOW.$this->getOS($player).C::RED." is here not allowed!", false);
            }
        }*/
        if ($player->spawned){
            $core->getServer()->getScheduler()->scheduleDelayedTask(new TitleTask($core, $player), 50); //2.5 Second.
        }
    }

    public function getOS(Player $player){
        switch ($player->getDeviceOS()){
            case 1:
                return "Android";
            case 2:
                return "IOS";
            case 7:
                return "Windows";
            case 8:
                return "Windows";
            default:
                return "Unknown";
        }
    }
}