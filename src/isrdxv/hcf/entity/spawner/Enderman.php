<?php

namespace isrdxv\hcf\entity\spawner;

use isrdxv\hcf\entity\spawner\Spawner;

use pocketmine\entity\{
  Living,
  EntitySizeInfo
};
use pocketmine\network\mcpe\protocol\types\EntityIds;

class Enderman extends Living implements Spawner
{
  
  public function getNetworkTypeId(): string
  {
    return EntityIds::ENDERMAN;
  }
  
  public function getInitialSizeInfo(): EntitySizeInfo
  {
    return new EntitySizeInfo(2.9, 0.6);
  }
  
  public function getName(): string
  {
    return "Enderman";
  }
  
  public function getXpDropAmount(): int
  {
    //TODO: does the enderman give xp? xd
		return 0;
	}
	
}