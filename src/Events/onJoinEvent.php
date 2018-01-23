<?php

namespace Events;

use CLACore\Core;
use pocketmine\Player;
use pocketmine\event\Listener;
use Tasks\{TitleTask, GuardianTask};
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\utils\{TextFormat as C, Config};

class onJoinEvent implements Listener {

	private $core;
	
	public function __construct(Core $core){
		$this->core = $core;
	}

	public function onJoin(PlayerJoinEvent $event){
		$player = $event->getPlayer();
		$name = $player->getName();
		$core = $this->core;

		#Guardian
		$config = new Config($this->core->getDataFolder()."config.yml", Config::YAML);
		if($config->get("Allow-Guardian") == true){
			$core->getServer()->getScheduler()->scheduleDelayedTask(new GuardianTask($core, $player), 25);
		}
		if($player->spawned){
			$core->getServer()->getScheduler()->scheduleDelayedTask(new TitleTask($core, $player), 50); //2.5 Second.
		}
	}
}