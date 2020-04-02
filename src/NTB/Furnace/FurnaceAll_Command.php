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

class FurnaceAll_Command extends Command{

	public function __construct(string $name, Plugin $caller){
		parent::__construct($name,"Cuit l'item dans votre inventaire","/furnaceall", []);
		$this->cl = $caller;
		$this->setPermission("Furnaceall.use");
	}

	public function execute(CommandSender $sender, $command, array $args){
		$pr = $this->cl->prefix;
		if(!$this->testPermission($sender)){
			$sender->sendMessage(new TranslationContainer("commands.generic.permission"));
			return false;
		}
		if(!$sender instanceof Player){
			$sender->sendMessage($pr.TF::RED."§9» §eVous ne pouvez utiliser cette commande depuis la console...");
			return;
		}
        $player = $sender;
        for ($i=0; $i < $player->getInventory()->getSize(); ++$i) { 
            $result = $this->cl->getFurnaceResult($player->getInventory()->getItem($i));
		    if($result != null)
		    {
			    $player->getInventory()->setItem($i, $result);
		    }
        }
		$player->sendMessage($pr.TF::GREEN."§9» §eVos items ont été cuit avec succès !");
		return true;
	}
}