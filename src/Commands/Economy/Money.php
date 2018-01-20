<?php

namespace Commands\Economy;

use pocketmine\Player;
use pocketmine\Server;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;

use pocketmine\utils\TextFormat as C;

use CLACore\Core;

class MoneyCommand extends PluginCommand{

    public function __construct($name, Core $plugin){
        parent::__construct($name, $plugin);
        $this->setDescription("Check your moneys.");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if ($sender instanceof Player) {
            $plugin = $this->getPlugin();
            $money = new Config($plugin->getDataFolder() . "money.yml", Config::YAML);
            $sender->sendMessage(C::YELLOW . "Money: " . C::GOLD . $money->get(strtolower($sender->getName())));
            return true;
        }
        return true;
    }
}