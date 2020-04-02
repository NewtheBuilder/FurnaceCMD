<?php
namespace NTB\Furnace;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase as Plugin;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;
use pocketmine\lang\TranslationContainer;
use pocketmine\item\Item;

class Furnace_Command extends Command{

	public function __construct(string $name, Plugin $caller){
		parent::__construct($name,"Cuit l'item dans votre main","/furnace", []);
		$this->cl = $caller;
		$this->setPermission("Furnace.use");
	}

	public function execute(CommandSender $sender, $command, array $args){
		$pr = $this->cl->prefix;
		if(!$this->testPermission($sender)){
			$sender->sendMessage(new TranslationContainer("commands.generic.permission"));
			return false;
		}
		if(!$sender instanceof Player){
			$sender->sendMessage($pr.TF::RED."Vous ne pouvez utiliser cette commande depuis la console...");
			return;
		}
		$player = $sender;
		$result = $this->cl->getFurnaceResult($player->getInventory()->getItemInHand());
		if($result != null)
		{
			$player->getInventory()->setItemInHand($result);
			$player->sendMessage($pr.TF::GREEN."§aVotre item a été cuit avec succès !");
		}
		else{
			$player->sendMessage($pr.TF::RED."§cMalheuresement cet item ne peut être cuit !");
			return false;
		}
		$player->sendMessage($pr.TF::GREEN."§aVotre Item à été cuit avec succès !");
		return true;
	}
}