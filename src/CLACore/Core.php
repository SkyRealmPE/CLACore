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

namespace CLACore;

use pocketmine\{Player, Server};
use pocketmine\plugin\PluginBase;
use pocketmine\utils\{TextFormat as C, Config};

#Commands
use Commands\{FlyCommand, SpawnCommand, PingCommand, ClearInventoryCommand, ClearlaggCommand};

#Teleport
use Commands\Teleport\{TpallCommand, TpoCommand, TpohereCommand};

#Economy
use Commands\Economy\{MoneyCommand, AddMoneyCommand, SeeMoneyCommand, SetMoneyCommand, TakeMoneyCommand};

#Events
use Events\{onBreakEvent, onDeathEvent, onJoinEvent, onRespawnEvent, onLoginEvent, onExhaustEvent, onMoveEvent};

#Rank
use Ranks\Rank;

#Tasks
use Tasks\{HighPingCheckTask, BroadcastTask, ClearlaggTask};

class Core extends PluginBase{

	public $cfg;
	public $money;

	public function onEnable(){
		$this->RegConfig();
		$this->RegEvents();
		$this->RegCommands();
		$this->RegEconomy();
		$this->RegTeleport();
		$this->RegTasks();
		$this->getLogger()->info(C::GREEN."Enabled.");
	}

	public function onDisable(){
		$this->getLogger()->info(C::RED."Disabled.");
	}

	#-----------Register config----------#

	public function RegConfig(){
		@mkdir($this->getDataFolder());

		$this->saveResource("broadcasts.yml");
		$this->saveResource("commands.yml");
		$this->saveResource("config.yml");
		$this->saveResource("deaths.yml");
		$this->saveResource("kills.yml");
		$this->saveResource("messages.yml");
		$this->saveResource("money.yml");
		$this->saveResource("rank.yml");
		$this->saveResource("title.yml");

		$this->broadcastcfg = new Config($this->getDataFolder() . "broadcasts.yml", Config::YAML);
		$this->cmdscfg = new Config($this->getDataFolder() . "commands.yml", Config::YAML);
		$this->cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML);
		$this->msgcfg = new Config($this->getDataFolder() . "messages.yml", Config::YAML);
		$this->moneycfg = new Config($this->getDataFolder() . "money.yml", Config::YAML);
   }

   #-----------Register events----------#

	public function RegEvents(){

		if($this->cfg->get("Allow-Rank") == true){
			$this->getServer()->getPluginManager()->registerEvents(($this->Rank = new Rank($this)), $this);
		}

		$this->getServer()->getPluginManager()->registerEvents(($this->onBreakEvent = new onBreakEvent($this)), $this);
		$this->getServer()->getPluginManager()->registerEvents(($this->onDeathEvent = new onDeathEvent($this)), $this);
		$this->getServer()->getPluginManager()->registerEvents(($this->onRespawnEvent = new onRespawnEvent($this)), $this);
		$this->getServer()->getPluginManager()->registerEvents(($this->onJoinEvent = new onJoinEvent($this)), $this);
		$this->getServer()->getPluginManager()->registerEvents(($this->onLoginEvent = new onLoginEvent($this)), $this);
		$this->getServer()->getPluginManager()->registerEvents(($this->onExhaustEvent = new onExhaustEvent($this)), $this);
		$this->getServer()->getPluginManager()->registerEvents(($this->onMoveEvent = new onMoveEvent($this)), $this);
	}

	#-----------Register commands----------#

	private function RegCommands(){

		if($this->cmdscfg->get("Fly") == true){
			$this->getServer()->getCommandMap()->register("fly", new FlyCommand("fly", $this));
		}

		if($this->cmdscfg->get("Ping") == true){
			$this->getServer()->getCommandMap()->register("ping", new PingCommand("ping", $this));
		}

		if($this->cmdscfg->get("Spawn") == true){
			$this->getServer()->getCommandMap()->register("Spawn", new SpawnCommand("Spawn", $this));
		}	

		if($this->cmdscfg->get("ClearInventory") == true){
			$this->getServer()->getCommandMap()->register("ClearInventory", new ClearInventoryCommand("ClearInventory", $this));
		}

		if($this->cmdscfg->get("Clearlagg") == true){
			$this->getServer()->getCommandMap()->register("Clearlagg", new ClearlaggCommand("Clearlagg", $this));
		}
	}

	#-----------Register economy----------#

	private function RegEconomy(){
		if($this->cmdscfg->get("Economy") == true){
			$this->getServer()->getCommandMap()->register("addmoney", new AddMoneyCommand("addmoney", $this));
			$this->getServer()->getCommandMap()->register("takemoney", new TakeMoneyCommand("takemoney", $this));
			$this->getServer()->getCommandMap()->register("setmoney", new SetMoneyCommand("setmoney", $this));
			$this->getServer()->getCommandMap()->register("seemoney", new SeeMoneyCommand("seemoney", $this));
			$this->getServer()->getCommandMap()->register("money", new MoneyCommand("money", $this));
		}
	}

	#-----------Register teleport----------#

	private function RegTeleport(){
		if($this->cmdscfg->get("Teleport") == true){
			$this->getServer()->getCommandMap()->register("Tpall", new TpallCommand("Tpall", $this));
			$this->getServer()->getCommandMap()->register("Tpo", new TpoCommand("Tpo", $this));
			$this->getServer()->getCommandMap()->register("Tpohere", new TpohereCommand("Tpohere", $this));
		}
	}

	#-----------Register tasks----------#

	private function RegTasks(){
		if($this->cfg->get("Allow-Broadcast") == true){
			$tick = $this->broadcastcfg->getNested("broadcast.tick");
			$this->getServer()->getScheduler()->scheduleRepeatingTask(new BroadcastTask($this), $tick); #20 = 1 second
		}

		if($this->cfg->get("Auto-ClearLagg") == true){
			$tick = $this->cmdscfg->get("Clearlagg-tick");
			$this->getServer()->getScheduler()->scheduleRepeatingTask(new ClearlaggTask($this), $tick); #20 = 1 second
		}

		if($this->cmdscfg->get("High-Ping-Kick") == true){
			$this->getServer()->getScheduler()->scheduleRepeatingTask(new HighPingCheckTask($this), 100); //5 Seconds.
		}
	}

	#-----------Other Economys----------#

	public function myMoney($player){
		if($player instanceof Player){
			$player = $player->getName();
		}
		$player = strtolower($player);
		$this->moneycfg->get($player);
		return $this->moneycfg->get($player);
	}

	public function reduceMoney($player, $money){
		if($player instanceof Player){
			$player = $player->getName();
		}
		if($this->myMoney($player) - $money < 0){
			return true;
		}
		$player = strtolower($player);
		$this->moneycfg->set($player, (int)$this->moneycfg->get($player) - $money);
		$this->moneycfg->save();
		return true;
	}

	public function addMoney($player, $money){
		if($player instanceof Player){
			$player = $player->getName();
		}
		if($this->myMoney($player) + $money < 0){
			return true;
		}
		$player = strtolower($player);
		$this->moneycfg->set($player, (int)$this->moneycfg->get($player) + $money);
		$this->moneycfg->save();
		return true;
	}
}
