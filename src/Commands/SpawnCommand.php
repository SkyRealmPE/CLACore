<?php

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