<?php

namespace Commands;

use pocketmine\Player;
use pocketmine\Server;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;

use pocketmine\utils\TextFormat as C;

use CLACore\Core;

class Heal extends PluginCommand{

    public function __construct($name, Core $plugin){
        parent::__construct($name, $plugin);
        $this->setDescription("Heal your self");
        $this->setPermission("core.heal");
    }

  
    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if(!$sender->hasPermission("core.heal")) {
            $sender->sendMessage(C::RED . "You are not allow to use '$commandLabel' command.");
        }
        if(!$sender instanceof Player) {
            $sender->sendMessage(C::RED . "Please use '$commandLabel' in game.");
        }
        if($sender->hasPermission("core.heal") || $sender->isOp()) {
            if ($sender instanceof Player) {
                
            }
        return true;
    }
}
