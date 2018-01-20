<?php

namespace Commands\Economy;

use pocketmine\Player;
use pocketmine\Server;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;

use pocketmine\utils\TextFormat as C;

use CLACore\Core;

class SeeMoney extends PluginCommand{

    public function __construct($name, Core $plugin){
        parent::__construct($name, $plugin);
        $this->setDescription("See other players money.");

    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        $plugin = $this->getPlugin();
        if ($sender instanceof Player) {
            if (!isset($args[0])) {
                $sender->sendMessage(C::RED . "That player cannot be found.");
                return true;
            }
            if (!isset($args[0])) {
                $sender->sendMessage("Usage: /seemoney <player>");
            }
            $money = new Config($plugin->getDataFolder() . "money.yml", Config::YAML);
            $sender->sendMessage(C::AQUA . $args[0] . "'s " . C::YELLOW . "Money: " . C::GOLD . $money->get(strtolower($args[0])));
            return true;
        }
        return true;
    }
}