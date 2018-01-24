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
use pocketmine\utils\{Textformat as C, Config};

#Commands
use Commands\{FlyCommand, SpawnCommand, PingCommand};

#Teleport
use Commands\Teleport\{TpallCommand, TpoCommand, TpohereCommand};

#Economy
use Commands\Economy\{MoneyCommand, AddMoneyCommand, SeeMoneyCommand, SetMoneyCommand, TakeMoneyCommand};

#Events
use Events\{onJoinEvent, onRespawnEvent, onLoginEvent, onExhaustEvent, onMoveEvent};

#Rank
use Ranks\Rank;

#Tasks
use Tasks\HighPingCheckTask;

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

	public function RegConfig(){
		@mkdir($this->getDataFolder());
		$this->saveResource("config.yml");
		$this->saveResource("rank.yml");
		$this->saveResource("title.yml");
		$this->saveResource("money.yml");
		$this->money = new Config($this->getDataFolder() . "money.yml", Config::YAML);
		$this->cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML);
   }

	public function RegEvents(){
		if($this->cfg->get("Allow-Rank") == true){
			$this->getServer()->getPluginManager()->registerEvents(($this->Rank = new Rank($this)), $this);
		}
		$this->getServer()->getPluginManager()->registerEvents(($this->onRespawnEvent = new onRespawnEvent($this)), $this);
		$this->getServer()->getPluginManager()->registerEvents(($this->onJoinEvent = new onJoinEvent($this)), $this);
		$this->getServer()->getPluginManager()->registerEvents(($this->onLoginEvent = new onLoginEvent($this)), $this);
		$this->getServer()->getPluginManager()->registerEvents(($this->onExhaustEvent = new onExhaustEvent($this)), $this);
		$this->getServer()->getPluginManager()->registerEvents(($this->onMoveEvent = new onMoveEvent($this)), $this);
	}

	private function RegCommands(){
		$this->getServer()->getCommandMap()->register("Spawn", new SpawnCommand("Spawn", $this));
		$this->getServer()->getCommandMap()->register("ping", new PingCommand("ping", $this));
		$this->getServer()->getCommandMap()->register("fly", new FlyCommand("fly", $this));
	}

	private function RegEconomy(){
		if($this->cfg->get("Allow-Economy") == true){
			$this->getServer()->getCommandMap()->register("addmoney", new AddMoneyCommand("addmoney", $this));
			$this->getServer()->getCommandMap()->register("takemoney", new TakeMoneyCommand("takemoney", $this));
			$this->getServer()->getCommandMap()->register("setmoney", new SetMoneyCommand("setmoney", $this));
			$this->getServer()->getCommandMap()->register("seemoney", new SeeMoneyCommand("seemoney", $this));
			$this->getServer()->getCommandMap()->register("money", new MoneyCommand("money", $this));
		}
	}

	private function RegTeleport(){
		if($this->cfg->get("Allow-Teleport") == true){
			$this->getServer()->getCommandMap()->register("Tpall", new TpallCommand("Tpall", $this));
			$this->getServer()->getCommandMap()->register("Tpo", new TpoCommand("Tpo", $this));
			$this->getServer()->getCommandMap()->register("Tpohere", new TpohereCommand("Tpohere", $this));
		}
	}

	private function RegTasks(){
		if($this->cfg->get("Enable-HighPingKick") == true){
			$this->getServer()->getScheduler()->scheduleRepeatingTask(new HighPingCheckTask($this), 100); //5 Seconds.
		}
	}

	public function myMoney($player){
		if($player instanceof Player){
			$player = $player->getName();
		}
		$player = strtolower($player);
		$moneyconf = new Config($this->getDataFolder() . "money.yml", Config::YAML);
		$moneyconf->get($player);
		return $moneyconf->get($player);
	}

	public function reduceMoney($player, $money){
		if($player instanceof Player){
			$player->getName();
		}
		if($this->myMoney($player) - $money < 0){
			return true;
		}
		$player = strtolower($player);
		$moneyconf = new Config($this->getDataFolder() . "money.yml", Config::YAML);
		$moneyconf->set($player, (int)$moneyconf->get($player) - $money);
		$moneyconf->save();
		return true;
	}

	public function addMoney($player, $money){
		if($player instanceof Player){
			$player->getName();
		}
		if($this->myMoney($player) + $money < 0){
			return true;
		}
		$player = strtolower($player);
		$moneyconf = new Config($this->getDataFolder() . "money.yml", Config::YAML);
		$moneyconf->set($player, (int)$moneyconf->get($player) + $money);
		$moneyconf->save();
		return true;
	}
}
