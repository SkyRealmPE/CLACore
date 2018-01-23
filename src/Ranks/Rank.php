<?php

namespace Ranks;


use CLACore\Core;
use pocketmine\Player;
use pocketmine\utils\Config;
use pocketmine\event\Listener;
use pocketmine\event\player\{PlayerJoinEvent, PlayerRespawnEvent, PlayerLoginEvent, PlayerChatEvent};


class Rank implements Listener{

	private $core;
	
	public function __construct(Core $core){
		$this->core = $core;
	}

	public function onLogin(PlayerLoginEvent $event){
		$player = $event->getPlayer();
		$this->setRank($player);
	}

	public function onJoin(PlayerJoinEvent $event){
		$player = $event->getPlayer();
		$this->setRank($player);
	}

	public function onRespawn(PlayerRespawnEvent $event){
		$player = $event->getPlayer();
		$this->setRank($player);
	}

	public function setRank(Player $player){
		$name = $player->getName();
		$rankcfg = new Config($this->core->getDataFolder() . "rank.yml", Config::YAML);
		$rank = $rankcfg->get($name);

		## Default ##
		$deftag = $rankcfg->get("Default-Tag");
		$deftag = str_replace("{name}", $name, $deftag);
		$player->setNameTag($deftag);

		## VIP ##
		if($rank == "VIP"){
			$viptag = $rankcfg->get("VIP-Tag");
			$viptag = str_replace("{name}", $name, $viptag);
			$player->setNameTag($viptag);
		}

		## VIP+ ##
		if($rank == "VIP+"){
			$vipplustag = $rankcfg->get("VIP+-Tag");
			$vipplustag = str_replace("{name}", $name, $vipplustag);
			$player->setNameTag($vipplustag);
		}

		## MVP ##
		if($rank == "MVP"){
			$mvptag = $rankcfg->get("MVP-Tag");
			$mvptag = str_replace("{name}", $name, $mvptag);
			$player->setNameTag($mvptag);
		}

		## MVP+ ##
		if($rank == "MVP+"){
			$mvpplustag = $rankcfg->get("MVP+-Tag");
			$mvpplustag = str_replace("{name}", $name, $mvpplustag);
			$player->setNameTag($mvpplustag);
		}

		## YouTuber ##
		if($rank == "YouTuber"){
			$yttag = $rankcfg->get("YouTuber-Tag");
			$yttag = str_replace("{name}", $name, $yttag);
			$player->setNameTag($yttag);
		}

		## Creator ##
		if($rank == "Creator"){
			$creatortag = $rankcfg->get("Creator-Tag");
			$creatortag = str_replace("{name}", $name, $creatortag);
			$player->setNameTag($creatortag);
		}

		## Owner ##
		if($rank == "Owner"){
			$ownertag = $rankcfg->get("Owner-Tag");
			$ownertag = str_replace("{name}", $name, $ownertag);
			$player->setNameTag($ownertag);
		}

		## CoOwner ##
		if($rank == "CoOwner"){
			$coownertag = $rankcfg->get("CoOwner-Tag");
			$coownertag = str_replace("{name}", $name, $coownertag);
			$player->setNameTag($coownertag);
		}

		## Admin ##
		if($rank == "Admin"){
			$admintag = $rankcfg->get("Admin-Tag");
			$admintag = str_replace("{name}", $name, $admintag);
			$player->setNameTag($admintag);
		}

		## Mod ##
		if($rank == "Mod"){
			$modtag = $rankcfg->get("Mod-Tag");
			$modtag = str_replace("{name}", $name, $modtag);
			$player->setNameTag($modtag);
		}

		## Developer ##
		if($rank == "Developer"){
			$devtag = $rankcfg->get("Developer-Tag");
			$devtag = str_replace("{name}", $name, $devtag);
			$player->setNameTag($devtag);
		}

		## Helper ##
		if($rank == "Helper"){
			$helpertag = $rankcfg->get("Helper-Tag");
			$helpertag = str_replace("{name}", $name, $helpertag);
			$player->setNameTag($helpertag);
		}

		## Staff ##
		if($rank == "Staff"){
			$stafftag = $rankcfg->get("Staff-Tag");
			$stafftag = str_replace("{name}", $name, $stafftag);
			$player->setNameTag($stafftag);
		}
	}

	public function onChat(PlayerChatEvent $event){
		$player = $event->getPlayer();
		$name = $player->getName();
		$msg = $event->getMessage();
		$rankcfg = new Config($this->core->getDataFolder() . "rank.yml", Config::YAML);
		$rank = $rankcfg->get($name);

		## Default ##
		$defchat = $rankcfg->get("Default-Chat");
		$defchat = str_replace("{name}", $name, $defchat);
		$defchat = str_replace("{msg}", $msg, $defchat);
		$event->setFormat($defchat);

		## VIP ##
		if($rank == "VIP"){
			$vipchat = $rankcfg->get("VIP-Chat");
			$vipchat = str_replace("{name}", $name, $vipchat);
			$vipchat = str_replace("{msg}", $msg, $vipchat);
			$event->setFormat($vipchat);
		}

		## VIP+ ##
		elseif($rank == "VIP+"){
			$vippluschat = $rankcfg->get("VIP+-Chat");
			$vippluschat = str_replace("{name}", $name, $vippluschat);
			$vippluschat = str_replace("{msg}", $msg, $vippluschat);
			$event->setFormat($vippluschat);
		}

		## MVP ##
		if($rank == "MVP"){
			$mvpchat = $rankcfg->get("MVP-Chat");
			$mvpchat = str_replace("{name}", $name, $mvpchat);
			$mvpchat = str_replace("{msg}", $msg, $mvpchat);
			$event->setFormat($mvpchat);
		}

		## MVP+ ##
		elseif($rank == "MVP+"){
			$mvppluschat = $rankcfg->get("MVP+-Chat");
			$mvppluschat = str_replace("{name}", $name, $mvppluschat);
			$mvppluschat = str_replace("{msg}", $msg, $mvppluschat);
			$event->setFormat($mvppluschat);
		}

		## YouTuber ##
		if($rank == "YouTuber"){
			$ytchat = $rankcfg->get("YouTuber-Chat");
			$ytchat = str_replace("{name}", $name, $ytchat);
			$ytchat = str_replace("{msg}", $msg, $ytchat);
			$event->setFormat($ytchat);
		}

		## Creator ##
		if($rank == "Creator"){
			$creatorchat = $rankcfg->get("Creator-Chat");
			$creatorchat = str_replace("{name}", $name, $creatorchat);
			$creatorchat = str_replace("{msg}", $msg, $creatorchat);
			$event->setFormat($creatorchat);
		}

		## Owner ##
		if($rank == "Owner"){
			$ownertag = $rankcfg->get("Owner-Chat");
			$ownertag = str_replace("{name}", $name, $ownertag);
			$ownertag = str_replace("{msg}", $msg, $ownertag);
			$event->setFormat($ownertag);
		}

		## CoOwner ##
		if($rank == "CoOwner"){
			$coownerchat = $rankcfg->get("CoOwner-Chat");
			$coownerchat = str_replace("{name}", $name, $coownerchat);
			$coownerchat = str_replace("{msg}", $msg, $coownerchat);
			$event->setFormat($coownerchat);
		}

		## Admin ##
		if($rank == "Admin"){
			$adminchat = $rankcfg->get("Admin-Chat");
			$adminchat = str_replace("{name}", $name, $adminchat);
			$adminchat = str_replace("{msg}", $msg, $adminchat);
			$event->setFormat($adminchat);
		}

		## Mod ##
		if($rank == "Mod"){
			$modchat = $rankcfg->get("Mod-Chat");
			$modchat = str_replace("{name}", $name, $modchat);
			$modchat = str_replace("{msg}", $msg, $modchat);
			$event->setFormat($modchat);
		}

		## Developer ##
		if($rank == "Developer"){
			$devchat = $rankcfg->get("Developer-Chat");
			$devchat = str_replace("{name}", $name, $devchat);
			$devchat = str_replace("{msg}", $msg, $devchat);
			$event->setFormat($devchat);
		}

		## Helper ##
		if($rank == "Helper"){
			$helperchat = $rankcfg->get("Helper-Chat");
			$helperchat = str_replace("{name}", $name, $helperchat);
			$helperchat = str_replace("{msg}", $msg, $helperchat);
			$event->setFormat($helperchat);
		}

		## Staff ##
		if($rank == "Staff"){
			$staffchat = $rankcfg->get("Staff-Chat");
			$staffchat = str_replace("{name}", $name, $staffchat);
			$staffchat = str_replace("{msg}", $msg, $staffchat);
			$event->setFormat($staffchat);
		}
	}
}