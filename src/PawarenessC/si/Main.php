<?php

namespace PawarenessC\si;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\scheduler\Task;

use Miste\scoreboardspe\API\Scoreboard;
use Miste\scoreboardspe\API\ScoreboardDisplaySlot;
use Miste\scoreboardspe\API\ScoreboardSort;
use Miste\scoreboardspe\API\ScoreboardAction;

use metowa1227\moneysystem\api\core\API;

class Main extends pluginBase implements Listener{
	
	public function onEnable(){
		$this->getLogger()->info("=========================");
		$this->getLogger()->info("Scoreboard Infoを読み込みました");
		$this->getLogger()->info("制作者: PawarenessC");
		$this->getLogger()->info("バージョン:{$this->getDescription()->getVersion()}");
		$this->getLogger()->info("=========================");
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		date_default_timezone_set('Asia/Tokyo');
	}
	
	public function getMoney(Player $p){
		return API::getInstance()->get($p);
	}
	
	public function getColor(int $ping){
		$color = ($ping < 150 ? TextFormat::GREEN : ($ping < 250 ? TextFormat::GOLD : TextFormat::RED));
		return $color;
	}
	
	public function onJoin(PlayerJoinEvent $e){
		$player = $e->getPlayer();
		$x = floor($player->getX());
		$y = floor($player->getY());
		$z = floor($player->getZ());
		$data = date("G:i");
		$money = $this->getMoney($player);
		$ping = $player->getPing();
		$c = $this->getColor($ping);
		
		$plugin = $this->getServer()->getPluginManager()->getPlugin("ScoreboardsPE")->getPlugin(); //必須
		$sb = new Scoreboard($plugin, "Komugi LIFE", ScoreboardAction::CREATE); //このKomugi LIFEってところがタイトル
		$sb->create(ScoreboardDisplaySlot::SIDEBAR, ScoreboardSort::DESCENDING);
		$sb->addDisplay($player); //プレイヤーにスコアボードのデータを送ると思えば良き
		//テンプレ文
		//$sb->setLine(行数,文);
		$sb->setLine(1,"Name: {$player->getName()}");
		$sb->setLine(2,"X:{$x} Y:{$y} Z: {$z}");
		$sb->setLine(3, "Time: {$data}");
		$sb->setLine(4, "Money: {$money}");
		$sb->setLine(5, "Ping: {$c}{$ping}");
	}
}
		
		
		
		
