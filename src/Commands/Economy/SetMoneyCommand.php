<?php

namespace Commands\Economy;

use CLACore\Core;
use pocketmine\{Player, Server};
use pocketmine\utils\{TextFormat as C, Config};
use pocketmine\command\{PluginCommand, CommandSender};

class SetMoneyCommand extends PluginCommand{

	public function __construct($name, Core $plugin){
		parent::__construct($name, $plugin);
		$this->setDescription("Set player money.");
		$this->setPermission("core.economy.set");
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){
		$plugin = $this->getPlugin();
		$prefix = $plugin->cfg->get("Economy-Prefix");
			if($sender->hasPermission("core.economy.set") || $sender->isOp()){
				if(!isset($args[1])){
					$sender->sendMessage("Usage: /setmoney <player> <money>");
					return true;
				}
				if(!is_numeric($args[1])){
					$sender->sendMessage("$prefix " . C::RED . "$args[1] isnt valid number.");
					return true;
				}
				$player = $plugin->getServer()->getPlayer($args[0]);
				if(!$player instanceof Player){
					if($player instanceof ConsoleCommandSender){
						$sender->sendMessage(C::RED . "$prefix " . C::RED . "Please provide a player.");
						return false;
					}
					$sender->sendMessage(C::RED . "$prefix " . C::RED . "$args[0] cannot be found.");
					return false;
				}
				$money = new Config($plugin->getDataFolder() . "money.yml", Config::YAML);
				if(!isset($args[1])){
					$sender->sendMessage("Usage: /setmoney <player> <money>");
					return true;
				}
				$nick = strtolower($player->getName());
				$money->set($nick, (int)$args[1]);
				$money->save();
				$sender->sendMessage("$prefix " . C::GREEN . "You have set up at " . C::AQUA . $player->getName() . C::GREEN . " " . $args[1] . C::GOLD . " money!");
				$player->sendMessage("$prefix " . C::GREEN . "Your money has been set to " . C::AQUA . $args[1]);
				return true;
			}
			if(!$sender->hasPermission("core.economy.set")){
				$sender->sendMessage(C::RED . "You are not allow to use '$commandLabel' command.");
			}
		return true;
	}
}