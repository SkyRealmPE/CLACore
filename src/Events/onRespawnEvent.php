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
