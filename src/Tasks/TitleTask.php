<?php

namespace Tasks;

use CLACore\Core;
use pocketmine\Player;
use pocketmine\utils\Config;
use pocketmine\scheduler\PluginTask;

class TitleTask extends PluginTask{

	private $core, $player;

	public function __construct(Core $core, Player $player){
		$this->core = $core;
		$this->player = $player;
		parent::__construct($core);
	}

	public function onRun(int $currentTick){
		$player = $this->player;
		$name = $player->getName();
		$core = $this->core;
		$titlecfg = new Config($core->getDataFolder() . "title.yml", Config::YAML);
		$title = $titlecfg->get("Title-Join-title");
		$title = str_replace("{name}", $name, $title);
		$subtitle = $titlecfg->get("Title-Join-subtitle");
		$subtitle = str_replace("{name}", $name, $subtitle);
		if($core->cfg->get("Title-Join") == true){
			if($player->isOnline()){
				$player->addTitle($title, $subtitle);
			}
		}
	}
}