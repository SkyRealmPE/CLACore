<?php

namespace Events;

use CLACore\Core;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;

class onMoveEvent implements Listener {

	private $core;

	public function __construct(Core $core){
		$this->core = $core;
	}

	public function onMove(PlayerMoveEvent $event){
		if($this->core->cfg->get("Allow-NoVoid") == true){
			if($event->getPlayer()->getLevel()->getName() === $this->core->cfg->get("No-Void-World")){
				if($event->getTo()->getFloorY() < 1){
					$player = $event->getPlayer();
					$player->teleport($this->core->getServer()->getDefaultLevel()->getSafeSpawn());
				}
			}
		}
	}
}