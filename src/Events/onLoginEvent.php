<?php

namespace Events;

use CLACore\Core;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerLoginEvent;

class onLoginEvent implements Listener{

	private $core;
	
	public function __construct(Core $core){
		$this->core = $core;
	}

	public function onLogin(PlayerLoginEvent $event){
		$player = $event->getPlayer();
		$core = $this->core;
		
		$player->setFood(20);
		$player->setHealth(20);
		if($core->cfg->get("Always-Spawn") == true){
			$player->teleport($core->getServer()->getDefaultLevel()->getSafeSpawn());
		}
	}
}
