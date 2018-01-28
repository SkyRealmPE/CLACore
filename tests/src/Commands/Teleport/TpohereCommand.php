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

class TpohereCommand extends PluginCommand{

	public function __construct($name, Core $plugin){
		parent::__construct($name, $plugin);
		$this->setDescription("Teleport player to you.");
		$this->setPermission("core.tpohere");
		$this->setAliases(["tpohere"]);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){

		if(!$sender->hasPermission("core.tpohere")){
			$sender->sendMessage(C::RED . "You are not allow to use '$commandLabel' command.");
			return true;
		}
		
		if(!$sender instanceof Player){
			$sender->sendMessage(C::RED . "Please use '$commandLabel' in game.");
			return true;
		}

		if(count($args) < 1){
			$sender->sendMessage("Usage: /tpohere <player>");
			return true;
		}

		$player = $this->getPlugin()->getServer()->getPlayer($args[0]);
		
		if($player === null){

			$players = [];

			foreach($this->getPlugin()->getServer()->getOnlinePlayers() as $onplayers) array_push($players, $onplayers->getName());
			sort($players);

			foreach($players as $onplayers){
				if(substr(strtolower($onplayers), 0, strlen($args[0])) !== strtolower($args[0])) continue;
				$player = $this->getPlugin()->getServer()->getPlayer($onplayers);
				break;
			}

			if($player === null){
				$sender->sendMessage(C::RED . "$args[0] cannot be found.");
				return true;
			}
		}

		$name = $player->getName();

		$player->teleport($sender->getPosition());
		$sender->sendMessage(C::GREEN . "Teleporting " . C::AQUA . "$name " . C::GREEN . "To you!");

		return true;
	}
}	   