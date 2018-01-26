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
		foreach(Server::getInstance()->getOnlinePlayers() as $players){
			if($players->getPing() > $this->plugin->cmdscfg->get("Max-Ping")){
				$players->kick(C::RED . "Kicked for high ping.", false);
			}
		}
	}
}
