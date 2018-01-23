<?php

namespace Commands\Economy;

use CLACore\Core;
use pocketmine\{Player, Server};
use pocketmine\utils\{TextFormat as C, Config};
use pocketmine\command\{PluginCommand, CommandSender};

class TakeMoney extends PluginCommand{
	
	public $main;

	public function __construct($name, Core $plugin){
		parent::__construct($name, $plugin);
		$this->main = $plugin;
		$this->setDescription("Remove player money.");
		$this->setPermission("core.economy.take");
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){
		$plugin = $this->getPlugin();
		$prefix = $plugin->cfg->get("Economy-Prefix");
		if($sender->hasPermission("core.economy.take") || $sender->isOp()){
				if ($sender->hasPermission("core.economy.take") || $sender->isOp()){
					if(!isset($args[1])){
						$sender->sendMessage("Usage: /takemoney <player> <money>");
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
					$nick = strtolower($player->getName());
					$money->set($nick, $money->get($nick) - $args[1] < 0);
					$money->save();
					$sender->sendMessage("$prefix " . C::GREEN . "You removed " . C::AQUA . $args[1] . C::GREEN . " money from " . C::AQUA . $player->getName() . ".");
					$sender->sendMessage("$prefix " . C::YELLOW . "The total money of " . C::AQUA . $player->getName() . ": " . C::GOLD . $money->get(strtolower($player->getName())));
					$player->sendMessage("$prefix " . C::RED . "Your $" . $args[1] . C::GREEN . " was removed from your account!");
					return true;
				}
				if(!$sender->hasPermission("core.economy.take")){
					$sender->sendMessage(C::RED . "You are not allow to use '$commandLabel' command.");
			}
			return true;
		}
		return true;
	}
}