<?php

/*
 * CLACore, a public core with many features for PocketMine-MP
 * Copyright (C) 2017-2018 CLADevs
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY;  without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace Tasks;

use CLACore\Core;
use pocketmine\Player;
use pocketmine\utils\Config;
use pocketmine\scheduler\PluginTask;
use pocketmine\network\mcpe\protocol\LevelEventPacket;

class GuardianTask extends PluginTask{

	private $plugin, $player;
	
	public function __construct(Core $plugin, Player $player){
		$this->plugin = $plugin;
		$this->player = $player;
		parent::__construct($plugin);
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
