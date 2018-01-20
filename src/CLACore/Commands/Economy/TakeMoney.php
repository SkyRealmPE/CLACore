<?php

namespace Commands\Economy;

use pocketmine\Player;
use pocketmine\Server;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;

use pocketmine\utils\Config;
use pocketmine\utils\TextFormat as C;

use CLACore\Core;

class TakeMoney extends PluginCommand{

    public function __construct($name, Core $plugin){
        parent::__construct($name, $plugin);
        $this->setDescription("Remove player money.");
        $this->setPermission("core.economy.take");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        $plugin = $this->getPlugin();
        $EconomyPrefix = new Config($plugin->getDataFolder() . "config.yml");
        $prefix = $EconomyPrefix->get("Economy-Prefix");
        if(!$sender instanceof Player) {
            $sender->sendMessage(C::RED . "Please use '$commandLabel' in game.");
        }
        if ($sender->hasPermission("core.economy.take") || $sender->isOp()) {
            if ($sender instanceof Player) {
                if ($sender->hasPermission("core.economy.take") || $sender->isOp()) {
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
                $nick = strtolower($player->getName());
                $money->set($nick, $money->get($nick) - $args[1] < 0);
                $money->save();
                $sender->sendMessage($prefix . C::GREEN . "You removed " . C::AQUA . $args[1] . C::GREEN . " money from " . C::AQUA . $player->getName() . ".");
                $sender->sendMessage($prefix . C::YELLOW . "The total money of " . C::AQUA . $player->getName() . ": " . C::GOLD . $money->get(strtolower($player->getName())));
                $player->sendMessage($prefix . C::RED . "Your $" . $args[1] . C::GREEN . " was removed from your account!");
                return true;
            }
            if (!$sender->hasPermission("core.economy.take")) {
                $sender->sendMessage(C::RED . "You are not allow to use '$commandLabel' command.");
            }
            return true;
        }
        return true;
    }
}
