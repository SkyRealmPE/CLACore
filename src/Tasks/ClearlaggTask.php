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

namespace Tasks;

use CLACore\Core;
use pocketmine\{Player, Server};
use pocketmine\scheduler\PluginTask;
use pocketmine\utils\{TextFormat as C, Config};
use pocketmine\entity\{Entity, Creature, Human};

class ClearlaggTask extends PluginTask{
	
	private $plugin;
	
	public function __construct(Core $plugin){
		$this->plugin = $plugin;
		parent::__construct($plugin);
	}
	
	public  function onRun(int $currentTick){
        $plugin = $this->plugin;
        switch($plugin->cmdscfg->getNested("Clearlagg-type")){
            case "clear":
            $this->removeEntities();
            $plugin->getServer()->broadcastMessage(C::GRAY . "(" . C::YELLOW . "ClearLagg" . C::GRAY . ") " . C::GREEN . "Removed " . C::YELLOW . "$entites " . C::GREEN . "entites.");
            break;
            case "killmobs":
            $this->removeMobs();
            $plugin->getServer()->broadcastMessage(C::GRAY . "(" . C::YELLOW . "ClearLagg" . C::GRAY . ") " . C::GREEN . "Removed " . C::YELLOW . "$entites " . C::GREEN . "mobs.");
            break;
            case "clearall":
            $mobs = $this->removeMobs();
            $entites = $this->removeEntities();
            $plugin->getServer()->broadcastMessage(C::GRAY . "(" . C::YELLOW . "ClearLagg" . C::GRAY . ") " . C::GREEN . "Removed " . C::YELLOW . "$mobs " . C::GREEN . "mobs, " . C::YELLOW . "$entites " . C::GREEN . "entites.");
            break;
        }
    }
    
    public function removeEntities(): int{
        $plugin = $this->plugin;
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
        $plugin = $this->plugin;
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
        
        public function exemptEntity(Entity $entity): void{
        $this->exemptedEntities[$entity->getID()] = $entity;
        }
        
        public function isEntityExempted(Entity $entity): bool{
        return isset($this->exemptedEntities[$entity->getID()]);
      }
}
