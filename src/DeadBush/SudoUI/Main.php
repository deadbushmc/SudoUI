<?php

namespace DeadBush\SudoUi;

use pocketmine\Player;

use pocketmine\plugin\PluginBase;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\event\Listener;

class Main extends PluginBase implements Listener {
	
	public function onEnable(){
		
	}
	
	public function onCommand(CommandSender $sender, Command $cmd, String $label, Array $args): bool {
		
		switch($cmd->getName()){
			case "sui":
			if($sender instanceof Player){
				if($sender->hasPermission("sudo.use")){
					$this->sudo($sender);
				}else{
					$sender->sendMessage("§4You Don't Have Permission To Use This Command");
				}
			}
		}
	return true;
	}
	
	public function sudo($player){
		$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function (Player $player, Array $data = null){
			if($data === null){
				return true;
			}
			$p = $this->getServer()->getPlayer($data[0]);
			$cmd = $data[1];
			if($p instanceof Player){
				$this->getServer()->dispatchCommand($p, $cmd);
				$player->sendMessage("§aYou sudo§3" . $p->getName() . " §aTodo / ". $data[1]);
			}
		});
		$form->setTitle("§l§5SudoUI§r");
		$form->addInput("Type a player name");
		$form->addInput("Type the command without /");
		$form->sendToPlayer($player);
		return $form;
	}
	
}