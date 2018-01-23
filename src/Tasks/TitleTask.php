<?php

namespace Tasks;

use CLACore\Core;
use pocketmine\Player;
use pocketmine\utils\Config;
use pocketmine\scheduler\PluginTask;

class TitleTask extends PluginTask{

	private $plugin, $player;

	public function __construct(Core $plugin, Player $player){
		$this->plugin = $plugin;
		$this->player = $player;
		parent::__construct($plugin);
	}

	public function onRun(int $currentTick){
		$player = $this->player;
		$name = $player->getName();
		$plugin = $this->plugin;
		$titlecfg = new Config($plugin->getDataFolder() . "title.yml", Config::YAML);
		$title = $titlecfg->get("Title-Join-title");
		$title = str_replace("{name}", $name, $title);
		$subtitle = $titlecfg->get("Title-Join-subtitle");
		$subtitle = str_replace("{name}", $name, $subtitle);
		if($plugin->cfg->get("Title-Join") == true){
			if($player->isOnline()){
				$player->addTitle($title, $subtitle);
			}
		}
	}
}