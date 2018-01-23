<?php

namespace Commands\Economy;

use CLACore\Core;
use pocketmine\{Player, Server};
use pocketmine\utils\{TextFormat as C, Config};
use pocketmine\command\{PluginCommand, CommandSender};

class Money extends PluginCommand{

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