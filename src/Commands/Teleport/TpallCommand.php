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

namespace Commands\Teleport;

use CLACore\Core;
use pocketmine\{Player, Server};
use pocketmine\utils\TextFormat as C;
use pocketmine\math\Vector3;
use pocketmine\level\Level;
use pocketmine\command\{PluginCommand, CommandSender};

class TpallCommand extends PluginCommand{

	public function __construct($name, Core $plugin){
		parent::__construct($name, $plugin);
		$this->setDescription("Teleport everyone to you.");
		$this->setPermission("core.tpall");
		$this->setAliases(["tpall"]);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){

		if(!$sender->hasPermission("core.tpall")){
			$sender->sendMessage(C::RED . "You are not allow to use '$commandLabel' command.");
			return true;
		}
		
		if(!$sender instanceof Player){
			$sender->sendMessage(C::RED . "Please use '$commandLabel' in game.");
			return true;
		}

		$name = $sender->getName();
		if($sender->hasPermission("core.tpall") || $sender->isOp()){
			foreach($this->getPlugin()->getServer()->getOnlinePlayers() as $players){
				$players->teleport(new Vector3($sender->x, $sender->y, $sender->z, $sender->getLevel()));
				$players->sendMessage(C::YELLOW . "Teleporting you to " . C::AQUA . "$name!");
			}
		}
		return true;
	}
}	   