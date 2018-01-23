<?php

namespace Commands;

use CLACore\Core;
use pocketmine\{Player, Server};
use pocketmine\utils\TextFormat as C;
use pocketmine\command\{PluginCommand, CommandSender};

class Fly extends PluginCommand{

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
					$sender->sendMessage(C::RED . "Fly disabled.");
					return true;
				} else {
					$this->addPlayer($sender);
					$sender->setAllowFlight(true);
					$sender->sendMessage(C::GREEN . "Fly enabled.");
					return true;
				}
			}
		}
		return true;
	}
}