<?php

namespace NTB\Furnace;

use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\TextFormat as TF;
use pocketmine\utils\Config;
use pocketmine\item\Item;

class Main extends PluginBase
{
	public static $instance;
	public static $logger = null;
	public $mode_eco = false;
	public $prefix = TF::BLUE."§9»".TF::RED."§eFurnace".TF::BLUE.":".TF::RESET;

	public function onLoad(){
		self::$logger = $this->getLogger();
		self::$instance =$this;
		$this->getServer()->getCommandMap()->register("Furnace", new Furnace_Command("furnace",$this));
		$this->getServer()->getCommandMap()->register("FurnaceAll", new FurnaceAll_Command("furnaceall",$this));
	}

	public function getFurnaceResult(Item $item) : ?Item{
		$recipe = $this->getServer()->getCraftingManager()->matchFurnaceRecipe($item);
		if($recipe != null && $item->getId() != 337)
		{
			$result = $recipe->getResult()->setCount($item->getCount());
			return $result;
		}
		return null;
	}

	public static function getInstance(){
		return self::$instance;
	}
}