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

namespace Commands\Economy;

use CLACore\Core;
use pocketmine\{Player, Server};
use pocketmine\utils\{TextFormat as C, Config};
use pocketmine\command\{PluginCommand, CommandSender};

class MoneyCommand extends PluginCommand{

	public function __construct($name, Core $plugin){
		parent::__construct($name, $plugin);
		$this->setDescription("Check your moneys.");
		$this->setAliases(["bal", "Bal", "Balance", "balance"]);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){
		$plugin = $this->getPlugin();
		$money = new Config($plugin->getDataFolder() . "money.yml", Config::YAML);
		if(!$sender instanceof Player) {
			$sender->sendMessage(C::RED . "Please use '$commandLabel' in game.");
		}
		if($sender instanceof Player){
			$sender->sendMessage(C::YELLOW . "Money: " . C::GOLD . $money->get(strtolower($sender->getName())));
			return true;
		}
		return true;
	}
}
