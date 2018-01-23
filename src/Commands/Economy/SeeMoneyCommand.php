<?php

namespace Commands\Economy;

use CLACore\Core;
use pocketmine\{Player, Server};
use pocketmine\utils\{TextFormat as C, Config};
use pocketmine\command\{PluginCommand, CommandSender};

class SeeMoneyCommand extends PluginCommand{

	public function __construct($name, Core $plugin){
		parent::__construct($name, $plugin);
		$this->setDescription("See other players money.");

	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){
		$plugin = $this->getPlugin();
		if(!isset($args[0])){
			$sender->sendMessage("Usage: /seemoney <player>");
			return true;
		}
		$money = new Config($plugin->getDataFolder() . "money.yml", Config::YAML);
		$sender->sendMessage(C::AQUA . $args[0] . "'s " . C::YELLOW . "Money: " . C::GOLD . $money->get(strtolower($args[0])));
		return true;
	}
}
