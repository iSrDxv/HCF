<?php

namespace isrdxv\hcf\entity\spawner;

use isrdxv\hcf\entity\spawner\Spawner;

use pocketmine\entity\{
  Living,
  EntitySizeInfo
};
use pocketmine\network\mcpe\protocol\types\EntityIds;

class Creeper extends Living implements Spawner
{
  
  public function getNetworkTypeId(): string
  {
    return EntityIds::CREEPER;
  }
  
  public function getInitialSizeInfo(): EntitySizeInfo
  {
    return new EntitySizeInfo(1.8, 0.6);
  }
  
  public function getName(): string
  {
    return "Creeper";
  }
  
  public function getXpDropAmount(): int
  {
    //TODO: check if killed by a player
		return 5;
	}
	
}
