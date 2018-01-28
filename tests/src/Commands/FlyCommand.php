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

namespace Commands;

use CLACore\Core;
use pocketmine\{Player, Server};
use pocketmine\utils\TextFormat as C;
use pocketmine\command\{PluginCommand, CommandSender};

class FlyCommand extends PluginCommand{

	private $players = array();

	public function __construct($name, Core $plugin){
		parent::__construct($name, $plugin);
		$this->setDescription("Turn fly on or off.");
		$this->setPermission("core.fly");
	}

	public function addPlayer(Player $player){
		$this->players[$player->getName()] = $player->getName();
	}

	public function isPlayer(Player $player){
		return in_array($player->getName(), $this->players);
	}

	public function removePlayer(Player $player){
		unset($this->players[$player->getName()]);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){
		$plugin = $this->getPlugin();
		$enablemessage = $plugin->msgcfg->get("Fly-Enable-Message");
		$disablemessage = $plugin->msgcfg->get("Fly-Disable-Message");
		$enablemessage = str_replace("{name}", $sender->getName(), $enablemessage);
		$disablemessage = str_replace("{name}", $sender->getName(), $disablemessage);

		if(!$sender->hasPermission("core.fly")){
			$sender->sendMessage(C::RED . "You are not allow to use '$commandLabel' command.");
		}
		if(!$sender instanceof Player){
			$sender->sendMessage(C::RED . "Please use '$commandLabel' in game.");
		}
		if($sender->hasPermission("core.fly") || $sender->isOp()){
			if($sender instanceof Player) {
				if($this->isPlayer($sender)){
					$this->removePlayer($sender);
					$sender->setAllowFlight(false);
					$sender->setFlying(false);
					$sender->sendMessage("$disablemessage");
					return true;
				} else {
					$this->addPlayer($sender);
					$sender->setAllowFlight(true);
					$sender->sendMessage("$enablemessage");
					return true;
				}
			}
		}
		return true;
	}
}