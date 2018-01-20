<?php

namespace CLACore;

use pocketmine\Player;
use pocketmine\Server;

use pocketmine\plugin\PluginBase;

use pocketmine\utils\Config;
use pocketmine\utils\Textformat as C;

#Commands
use Commands\Ping;
use Commands\Spawn;
use Commands\Fly;

#Economy
use Commands\AddMoney;
use Commands\Money;
use Commands\SeeMoney;
use Commands\SetMoney;
use Commands\TakeMoney;

#Events
use Events\onRespawnEvent;
use Events\onJoinEvent;
use Events\onLoginEvent;
use Events\onExhaustEvent;
use Events\onMoveEvent;

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
        $this->getServer()->getCommandMap()->register("Spawn", new Spawn("Spawn", $this));
        $this->getServer()->getCommandMap()->register("ping", new Ping("ping", $this));
        $this->getServer()->getCommandMap()->register("fly", new Fly("fly", $this));
    }

    private function RegEconomy(){
        if($this->cfg->get("Allow-Money") == true){
            $this->getServer()->getCommandMap()->register("addmoney", new AddMoney("addmoney", $this));
            $this->getServer()->getCommandMap()->register("takemoney", new TakeMoney("takemoney", $this));
            $this->getServer()->getCommandMap()->register("setmoney", new SetMoney("setmoney", $this));
            $this->getServer()->getCommandMap()->register("seemoney", new SeeMoney("seemoney", $this));
            $this->getServer()->getCommandMap()->register("money", new Money("money", $this));
        }
    }

    private function RegTasks(){
        if ($this->cfg->get("Enable-HighPingKick") == true){
            $this->getServer()->getScheduler()->scheduleRepeatingTask(new HighPingCheckTask($this), 100); //5 Seconds.
        }
    }

    public function myMoney($player){
        if ($player instanceof Player) {
            $player = $player->getName();
        }
        $player = strtolower($player);
        $moneyconf = new Config($this->getDataFolder() . "money.yml", Config::YAML);
        $moneyconf->get($player);
        return $moneyconf->get($player);
    }

    public function reduceMoney($player, $money){
        if ($player instanceof Player) {
            $player->getName();
        }
        if ($this->myMoney($player) - $money < 0) {
            return true;
        }
        $player = strtolower($player);
        $moneyconf = new Config($this->getDataFolder() . "money.yml", Config::YAML);
        $moneyconf->set($player, (int)$moneyconf->get($player) - $money);
        $moneyconf->save();
        return true;
    }

    public function addMoney($player, $money){
        if ($player instanceof Player) {
            $player->getName();
        }
        if ($this->myMoney($player) + $money < 0) {
            return true;
        }
        $player = strtolower($player);
        $moneyconf = new Config($this->getDataFolder() . "money.yml", Config::YAML);
        $moneyconf->set($player, (int)$moneyconf->get($player) + $money);
        $moneyconf->save();
        return true;
    }
}