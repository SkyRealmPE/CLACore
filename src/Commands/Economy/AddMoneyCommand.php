<?php

namespace Commands\Economy;

use CLACore\Core;
use pocketmine\{Player, Server};
use pocketmine\utils\{TextFormat as C, Config};
use pocketmine\command\{PluginCommand, CommandSender, ConsoleCommandSender};

class AddMoneyCommand extends PluginCommand{

	public function __construct($name, Core $plugin){
		parent::__construct($name, $plugin);
		$this->setDescription("Add Money to Players.");
		$this->setPermission("core.economy.add");
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){
		if(!$sender->hasPermission("core.economy.add")){
			$sender->sendMessage(C::RED . "You are not allow to use '$commandLabel' command.");
			return true;
		}
		$plugin = $this->getPlugin();
		$prefix = $plugin->cfg->get("Economy-Prefix");
		if($sender->hasPermission("core.economy.add") || $sender->isOp()){
				if(!isset($args[1])){
					$sender->sendMessage("Usage: /addmoney <player> <money>");
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
					$sender->sendMessage("Usage: /addmoney <player> <money>");
					return true;
				}
				$nick = strtolower($player->getName());
				$money->set($nick, $money->get($nick) + $args[1]);
				$money->save();
				$sender->sendMessage("$prefix " . C::GREEN . "You added " . C::AQUA . $args[1] . C::GREEN . " money at " . C::AQUA . $player->getName() . ".");
				$sender->sendMessage("$prefix " . C::YELLOW . "The total money of " . C::AQUA . $player->getName() . ": " . C::GOLD . $money->get(strtolower($player->getName())));
				$player->sendMessage("$prefix " . C::GREEN . "You have been added " . C::AQUA . $args[1] . C::GREEN . " money on your account!");
			return true;
		}
		return true;
	}
}
