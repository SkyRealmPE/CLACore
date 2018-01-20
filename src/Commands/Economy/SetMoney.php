<?php

namespace Commands\Economy;

use pocketmine\Player;
use pocketmine\Server;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;

use pocketmine\utils\Config;
use pocketmine\utils\TextFormat as C;

use CLACore\Core;

class SetMoney extends PluginCommand{

    public function __construct($name, Core $plugin){
        parent::__construct($name, $plugin);
        $this->setDescription("Set player money.");
        $this->setPermission("core.economy.set");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        $plugin = $this->getPlugin();
        $EconomyPrefix = new Config($plugin->getDataFolder() . "config.yml");
        $prefix = $EconomyPrefix->get("Economy-Prefix");
        if(!$sender instanceof Player) {
            $sender->sendMessage(C::RED . "Please use '$commandLabel' in game.");
        }
        if ($sender instanceof Player) {
            if ($sender->hasPermission("core.economy.set") || $sender->isOp()) {
                if (!isset($args[1])) {
                    $sender->sendMessage($prefix . C::RED . "That name isnt valid.");
                    return true;
                }
                if (!is_numeric($args[1])) {
                    $sender->sendMessage($prefix . C::RED . "That number isnt valid.");
                    return true;
                }
                $player = $this->main->getServer()->getPlayer($args[0]);
                $money = new Config($this->main->getDataFolder() . "money.yml", Config::YAML);
                if (!isset($args[1])) {
                    $sender->sendMessage("Usage: /setmoney <player> <money>");
                    return true;
                }
                $nick = strtolower($player->getName());
                $money->set($nick, (int)$args[1]);
                $money->save();
                $sender->sendMessage($prefix . C::GREEN . "You have set up at " . C::AQUA . $player->getName() . C::GREEN . $args[1] . C::GOLD . " money!");
                $player->sendMessage($prefix . C::GREEN . "Your money has been set to " . C::AQUA . $args[1]);
                return true;
            }
            if (!$sender->hasPermission("core.economy.set")) {
                $sender->sendMessage(C::RED . "You are not allow to use '$commandLabel' command.");
            }
            return true;
        }
        return true;
    }
}