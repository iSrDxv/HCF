<?php

namespace isrdxv\hcf\entity\spawner;

use isrdxv\hcf\entity\spawner\Spawner;

use pocketmine\entity\{
  Living,
  EntitySizeInfo
};
use pocketmine\network\mcpe\protocol\types\EntityIds;

class Cow extends Living implements Spawner
{
  
  public function getNetworkTypeId(): string
  {
    return EntityIds::COW;
  }
  
  public function getInitialSizeInfo(): EntitySizeInfo
  {
    return new EntitySizeInfo(1.3, 0.9);
  }
  
  public function getName(): string
  {
    return "Cow";
  }
  
  public function getXpDropAmount(): int
  {
    //TODO: check if killed by a player
		return mt_rand(1,3);
	}
	
}
