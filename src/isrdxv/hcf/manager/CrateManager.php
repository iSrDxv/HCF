<?php

namespace isrdxv\hcf\manager;

use isrdxv\hcf\HCFLoader;

use pocketmine\item\Item;

class CrateManager
{
  private array $crates = [];
  
  public function __construct(HCFLoader $loader)
  {
    foreach(glob($loader->getDataFolder() . "crates/*") as $file) {
      if (!is_file($file)) {
        return;
      }
      $extension = $loader->data_extension;
      $content = $loader->getProvider()->getAll($file);
      $this->setCrate(basename($file, "." . $extension), $content);
    }
  }
  
}
