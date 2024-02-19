<?php

namespace isrdxv\hcf\manager;

use isrdxv\hcf\HCFLoader;
use isrdxv\hcf\crate\Crate;
use isrdxv\hcf\utils\Result;

use pocketmine\item\Item;
use pocketmine\utils\SingletonTrait;

class CrateManager
{
  use SingletonTrait;
  
  private array $crates = [];
  
  public function init(HCFLoader $loader)
  {
    foreach(glob($loader->getDataFolder() . "crates/*.json") as $file) {
      if (!is_file($file)) {
        return;
      }
      $this->set(basename($file, ".json"), $loader->getProvider()->getAll($file));
    }
  }
  
  public function create(array $crateData): bool
  {
    if ($this->exists($crateData["name"])) {
      return false;
    }
    //save file
    $this->crates[$crateData["name"]] = new Crate($crateData["name"], $crateData["customName"]);
    return true;
  }
  
  public function set(string $name, array $data): void
  {
    if ($this->exists($name)) {
      return;
    }
    $this->crates[$name] = new Crate($data["name"], $data["customName"], $data["blockId"], Result::decodeItemsContent($data["items"]));
  }
  
  public function get(string $name): ?Crate
  {
    return $this->crates[$name] ?? null;
  }
  
  public function getAll(): array
  {
    return $this->crates;
  }
  
  public function exists(string $name): bool
  {
    return isset($this->crates[$name]) ? true : false;
  }
  
}