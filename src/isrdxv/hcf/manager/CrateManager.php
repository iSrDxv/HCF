<?php

namespace isrdxv\hcf\manager;

use isrdxv\hcf\HCFLoader;
use isrdxv\hcf\crate\Crate;
use isrdxv\hcf\utils\Result;

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
      $this->set(basename($file, $extension), $content);
    }
  }
  
  public function create(array $crateData): bool
  {
    if ($this->exists($crateData["name"])) {
      return;
    }
    //save file
    $this->crates[$crateData["name"]] = new Crate();
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
