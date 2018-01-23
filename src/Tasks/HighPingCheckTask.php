<?php

namespace Tasks;

use CLACore\Core;
use pocketmine\Server;
use pocketmine\scheduler\PluginTask;
use pocketmine\utils\{TextFormat as C, Config};

class HighPingCheckTask extends PluginTask {
	
	private $plugin;
	
	public function __construct(Core $plugin){
		$this->plugin = $plugin;
		parent::__construct($plugin);
	}
	
	public  function onRun(int $currentTick){
		$config = new Config($this->plugin->getDataFolder()."config.yml", Config::YAML);
		foreach(Server::getInstance()->getOnlinePlayers() as $players){
			if($players->getPing() > $config->get("Max-Ping")){
				$players->kick(C::RED . "You have been removed from the game because you have a high ping", false);
			}
		}
	}
}