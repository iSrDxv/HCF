<?php

namespace isrdxv\hcf\crate\block;

use pocketmine\block\Chest;

class CrateChest
{
  private string $blockId;
  
  public function __construct(string $blockId)
  {
    $this->blockId = $blockId;
    parent::__construct();
  }
  
}