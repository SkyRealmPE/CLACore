<?php

/*
 * CLACore, a public core with many features for PocketMine-MP
 * Copyright (C) 2017-2018 CLADevs
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY;  without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace Commands;

use CLACore\Core;
use pocketmine\entity\{Entity, Creature, Human};
use pocketmine\{Player, Server};
use pocketmine\utils\TextFormat as C;
use pocketmine\command\{PluginCommand, CommandSender};

class ClearlaggCommand extends PluginCommand{

	public function __construct($name, Core $plugin){
		parent::__construct($name, $plugin);
		$this->setDescription("Clear the lag.");
    $this->setAliases(["clearlagg"]);
    $this->setPermission("core.clearlagg");
  }
	 
	public function execute(CommandSender $sender, string $commandLabel, array $args): bool{

        $plugin = $this->getPlugin();

        if(!$sender->hasPermission("core.clearlagg")){
            $sender->sendMessage(C::RED . "You are not allow to use '$commandLabel' command.");
            return true;
        }

        if(count($args) < 1){
            $sender->sendMessage("Usage: /clearlagg <clear|check|killmobs|clearall>");
            return true;
        }

        switch($args[0]){
            case "clear":
            $entites = $this->removeEntities();
            $sender->sendMessage(C::GREEN . "Removed " . C::YELLOW . "$entites " . C::GREEN . "entites.");
            break;
            case "check":
            $entites = $this->getEntityCount();
            $sender->sendMessage(C::YELLOW . "Players: " . C::AQUA . "$entites[0]");
            $sender->sendMessage(C::YELLOW . "Mobs: " . C::AQUA . "$entites[1]");
            $sender->sendMessage(C::YELLOW . "Entites: " . C::AQUA . "$entites[2]");
            break;
            case "killmobs":
            $entites = $this->removeMobs();
            $sender->sendMessage(C::GREEN . "Removed " . C::YELLOW . "$entites " . C::GREEN . "mobs.");
            break;
            case "clearall":
            $mobs = $this->removeMobs();
            $entites = $this->removeEntities();
            $sender->sendMessage(C::GREEN . "Removed " . C::YELLOW . "$mobs " . C::GREEN . "mobs, " . C::YELLOW . "$entites " . C::GREEN . "entites.");
            break;
            default:
            $sender->sendMessage("Usage: /clearlagg <clear|check|killmobs|clearall>");
            break;
        }

		return true;
    }

    public function removeEntities(): int{
      $plugin = $this->getPlugin();
      $i = 0;
      foreach($plugin->getServer()->getLevels() as $level){
        foreach($level->getEntities() as $entity){
          if(!$this->isEntityExempted($entity) && !($entity instanceof Creature)){
            $entity->close();
            $i++;
          }
        }
      }
      return $i;
      }
      
      public function removeMobs(): int{
      $plugin = $this->getPlugin();
      $i = 0;
      foreach($plugin->getServer()->getLevels() as $level){
        foreach($level->getEntities() as $entity) {
          if(!$this->isEntityExempted($entity) && $entity instanceof Creature && !($entity instanceof Human)){
            $entity->close();
            $i++;
          }
        }
      }
      return $i;
      }
      
      public function getEntityCount(): array{
      $plugin = $this->getPlugin();
      $ret = [0, 0, 0];
      foreach($plugin->getServer()->getLevels() as $level){
        foreach($level->getEntities() as $entity){
          if($entity instanceof Human){
            $ret[0]++;
          } else {
            if($entity instanceof Creature){
              $ret[1]++;
            } else {
              $ret[2]++;
            }
          }
        }
      }
      return $ret;
      }
      
      public function exemptEntity(Entity $entity): void{
      $this->exemptedEntities[$entity->getID()] = $entity;
      }
      
      public function isEntityExempted(Entity $entity): bool{
      return isset($this->exemptedEntities[$entity->getID()]);
    }
}
