<?php

namespace Tasks;

use CLACore\Core;
use pocketmine\Player;
use pocketmine\utils\Config;
use pocketmine\scheduler\PluginTask;
use pocketmine\network\mcpe\protocol\LevelEventPacket;

class GuardianTask extends PluginTask{

	private $player;
	
	public function __construct(Player $player){
		$this->player = $player;
	}

	public function onRun(int $currentTick){
		$player = $this->player;
		$pk = new LevelEventPacket();
		$pk->evid = LevelEventPacket::EVENT_GUARDIAN_CURSE;
		$pk->data = 1;
		$pk->position = $player->asVector3();
		$player->dataPacket($pk);
	}
}