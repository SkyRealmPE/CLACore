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
use pocketmine\command\{PluginCommand, CommandSender, ConsoleCommandSender};
use pocketmine\item\Item;
use pocketmine\inventory\Inventory;

class ClearInventoryCommand extends PluginCommand{

	public function __construct($name, Core $plugin){
		parent::__construct($name, $plugin);
		$this->setDescription("Clear a player inventory.");
		$this->setPermission("core.clearinventory", "core.clearinv");
		$this->setAliases(["clearinventory", "clearinv"]);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){
		$plugin = $this->getPlugin();
		$sendermessage = $plugin->msgcfg->get("ClearInventory-sender-Message");
		$playermessage = $plugin->msgcfg->get("ClearInventory-player-Message");
		if(!$sender->hasPermission("core.clearinventory", "core.clearinv")){
			$sender->sendMessage(C::RED . "You are not allow to use '$commandLabel' command.");
			return true;
		}
		if(count($args) < 1){
			$sender->sendMessage("Usage: /clearinv <all> <player>");
			return true;
		}
		switch($args[0]){
			case "all":
			case "All":
			if(count($args) < 2){
				$sender->sendMessage("Usage: /clearinv all <player>");
				return true;
			}
			if(isset($args[1])){
				$player = $plugin->getServer()->getPlayer($args[1]);
				if (!$player instanceof Player) {
					if ($player instanceof ConsoleCommandSender){
						$sender->sendMessage(C::RED . "Please provide a player.");
						return false;
					}
					$sender->sendMessage(C::RED . "Could'nt find player " . $args[1] . ".");
					return false;
				}
			}
			$sendermessage = str_replace("{name}", $player->getName(), $sendermessage);
			$inv = $player->getInventory();
			$inv->ClearAll();
			$player->sendMessage("$playermessage");
			$sender->sendMessage("$sendermessage");
			break;
			default:
			$sender->sendMessage("Usage: /clearinv <all> <player>");
			break;
		}
		return true;
	}
}
