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
namespace Events;
use CLACore\Core;
use pocketmine\utils\Config;
use pocketmine\event\Listener;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\player\PlayerDeathEvent;
class onDeathEvent implements Listener {
	
	private $plugin;
	
	public function __construct(Core $plugin){
		$this->plugin = $plugin;
	}
	
	public function onDeath(PlayerDeathEvent $event){
		$player = $event->getPlayer();
    $datak = new Config($this->plugin->getDataFolder()."kills.yml", Config::YAML);
    $datad = new Config($this->plugin->getDataFolder()."deaths.yml", Config::YAML);
    if($player->getLastDamageCause() instanceof EntityDamageByEntityEvent) {
      if($player->getLastDamageCause()->getDamager() instanceof Player) {
        $killer = $player->getLastDamageCause()->getDamager();
        $kills = $datak->get($killer->getName());
        $deaths = $datad->get($killer->getName());
	$deathmessage = $this->plugin->msgcfg->get("Death-Message");
        $message = str_replace("{VICTIM}", $player->getName(), $deathmessage);
        $message = str_replace("{VICTIM-DEATHS}", $deaths, $deathmessage);
        $message = str_replace("{KILLER}", $killer->getName(), $deathmessage);
        $message = str_replace("{KILLER-KILLS}", $kills, $deathmessage);
        $event->setDeathMessage($message);
        if($kills == "") {
          $datak->set($killer->getName(), 1);
          $datak->save();
        } else {
          $datak->set($killer->getName(), $kills + 1);
          $datak->save();
        }
        if($deaths == "") {
          $datad->set($player->getName(), 1);
          $datad->save();
        } else {
          $datad->set($player->getName(), $deaths + 1);
          $datad->save();
        }
      }
    }
	}
}
