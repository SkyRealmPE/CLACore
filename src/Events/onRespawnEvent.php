<?php

namespace Events;

use CLACore\Core;
use pocketmine\utils\Config;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerRespawnEvent;

class onRespawnEvent implements Listener {

	private $core;

	public function __construct(Core $core){
		$this->core = $core;
	}
	public function onRespawn(PlayerRespawnEvent $event){
		$player = $event->getPlayer();
		$name = $player->getName();
		$core = $this->core;
		$titlecfg = new Config($core->getDataFolder() . "title.yml", Config::YAML);
		$title = $titlecfg->get("Title-Respawn-title");
		$title = str_replace("{name}", $name, $title);
		$subtitle = $titlecfg->get("Title-Respawn-subtitle");
		$subtitle = str_replace("{name}", $name, $subtitle);
		if($core->cfg->get("Title-Respawn") == true){
			$player->addTitle($title, $subtitle);
		}
	}
}