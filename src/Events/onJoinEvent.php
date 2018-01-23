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
