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
