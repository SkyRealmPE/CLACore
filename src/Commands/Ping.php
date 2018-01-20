<?php

namespace Commands;

use pocketmine\Player;
use pocketmine\Server;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;

use pocketmine\utils\TextFormat as C;

use CLACore\Core;

class Ping extends PluginCommand{

    public function __construct($name, Core $plugin){
        parent::__construct($name, $plugin);
        $this->setDescription("Check your ping.");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if (!$sender instanceof Player) {
            $sender->sendMessage(C::RED . "Please use '$commandLabel' in game.");
        }
        if ($sender instanceof Player) {
            $ping = $sender->getPing();
            $color = C::GREEN;
            if($ping >= 150 and $ping <= 250){
                $color = C::GOLD;
            }elseif($ping >= 250 and $ping <= 350){
                $color = C::RED;
            }elseif($ping > 350){
                $color = C::DARK_RED;   
            }
            $sender->sendMessage(C::GRAY . " Your ping is " . $color . $ping . "ms");
            return true;
        }
        return true;
    }
}