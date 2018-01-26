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
use pocketmine\math\Vector3;
use pocketmine\{Player, Server};
use pocketmine\utils\TextFormat as C;
use pocketmine\level\sound\EndermanTeleportSound;
use pocketmine\command\{PluginCommand, CommandSender};

class SpawnCommand extends PluginCommand{

	public function __construct($name, Core $plugin){
		parent::__construct($name, $plugin);
		$this->setDescription("Teleport to spawn.");
		$this->setAliases(["spawn"]);
	}
	 
	public function execute(CommandSender $sender, string $commandLabel, array $args): bool{
		if($sender instanceof Player){
			$level = $sender->getLevel();
			$x = $sender->getX();
			$y = $sender->getY();
			$z = $sender->getZ();
			$sender->setFood(20);
			$sender->setHealth(20);
			$name = $sender->getName();
			$sender->sendMessage(C::GRAY . "§7Welcome back, " . C::RED . $name);
			$spawn = new Vector3($x, $y, $z);
			$sender->sendMessage(C::GREEN . "Teleporting to spawn.");
			$sender->teleport($this->getPlugin()->getServer()->getDefaultLevel()->getSafeSpawn());
			$level->addSound(new EndermanTeleportSound($spawn));
		} else {
			$sender->sendMessage(C::RED . "Please use '$commandLabel' in game.");
		}
		return true;
	}
}
