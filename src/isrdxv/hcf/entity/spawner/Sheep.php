<?php

namespace isrdxv\hcf\entity\spawner;

use isrdxv\hcf\entity\spawner\Spawner;

use pocketmine\entity\{
  Living,
  EntitySizeInfo
};
use pocketmine\network\mcpe\protocol\types\EntityIds;

class Sheep extends Living implements Spawner
{
  
  public function getNetworkTypeId(): string
  {
    return EntityIds::SHEEP;
  }
  
  public function getInitialSizeInfo(): EntitySizeInfo
  {
    return new EntitySizeInfo(0.65, 0.45);
  }
  
  public function getName(): string
  {
    return "Sheep";
  }
  
  public function getDrops(): array;
  
  public function getXpDropAmount(): int
  {
		return 0;
	}
	
}
