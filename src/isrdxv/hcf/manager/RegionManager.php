<?php

namespace isrdxv\hcf\manager;

use const JSON_PRETTY_PRINT;
use const JSON_BIGINT_AS_STRING;
use const JSON_THROW_ON_ERROR;

use isrdxv\hcf\HCFLoader;
use isrdxv\hcf\region\{
  Region,
  utils\RegionData,
  utils\RegionPosition
};

use pocketmine\world\World;
use pocketmine\utils\Filesystem;

class RegionManager
{
  private HCFLoader $loader;
  
  /** @var Region[] **/
  private array $regions = [];
  
  /** @var RegionCreator[] **/
  private array $creators = [];
  
  public function __construct(HCFLoader $loader)
  {
    $this->loader = $loader;
    foreach(glob($loader->getDataFolder() . "regions" . DIRECTORY_SEPARATOR . "*.json") as $file) {
      if (is_file($file)) {
        $region = json_decode(file_get_contents($file), true);
        $region = new Region($region["name"], $region["custom_name"], $region["pvp_rule"], $region["block_rule"], $region["hunger_rule"], $loader->getServer()->getWorldManager()->getWorldByName($region["world"]));
        $region->setFirstPosition(RegionPosition::fromString($region["first_position"]));
        $region->setSecondPosition(RegionPosition::fromString("second_position"));
        $this->regions[$region->getName()] = $region;
      }
    }
  }
  
  //esto cuando creas la region
  public function createRegion(RegionData $regionData): void
  {
    if ($this->isRegion($regionData->name)) {
      //texto aqui xd
      return;
    }
    $this->regions[$regionData->name] = new Region($regionData->name, $regionData->custom_name, $regionData->pvp_rule, $regionData->block_rule, $regionData->hunger_rule, $regionData->world);
  }
  
  //esto es mas para cuando crean los spawns de la region xd
  public function setRegion(string $username, RegionData $regionData): void
  {
    if (!$this->isCreator($username)) {
      return;
    }
    $region = new Region($regionData->name, $regionData->custom_name, $regionData->pvp_rule, $regionData->block_rule, $regionData->hunger_rule, $regionData->world);
    $region->setFirstPosition($regionData->first_position);
    $region->setSecondPosition($refionData->second_position);
    $this->regions[$regionData->name] = $region;
    $this->saveRegion($regionData->name);
    $this->deleteCreator($username);
  }
  
  public function isRegion(string $name): bool
  {
    if (empty($this->regions)) {
      return false;
    }
    if (isset($this->regions[$name])) {
      return true;
    }
    return false;
  }
  
  public function worldExistsRegion(string $world): bool
  {
    if (empty($this->regions)) {
      return false;
    }
    foreach($this->regions as $region) {
      if ($region->getWorld()->getFolderName() === $world) {
        return true;
      }
    }
    return false;
  }
  
  public function deleteRegion(Region $region): void
  {
    if (!$this->isRegionFile($region->getName())) {
      return;
    }
    unset($this->regions[$region->getName()]);
    @unlink($this->loader->getDataFolder() . "regions" . DIRECTORY_SEPARATOR . $region->getName() . ".json");
  }
  
  public function isRegionFile(string $name): bool
  {
    return is_file($this->loader->getDataFolder() . "regions" . DIRECTORY_SEPARATOR . $name . ".json");
  }
  
  public function saveRegion(string $name): void
  {
    if (is_file($this->loader->getDataFolder() . "regions" . DIRECTORY_SEPARATOR . $name . ".json")) {
      continue;
    }
    Filesystem::safeFilePutContents($this->loader->getDataFolder() . "regions" . DIRECTORY_SEPARATOR . $name . ".json", json_encode($this->regions[$name]->jsonSerialize(), JSON_PRETTY_PRINT | JSON_BIGINT_AS_STRING | JSON_THROW_ON_ERROR));
  }
  
  public function getRegions(): array
  {
    return $this->regions;
  }
  
  public function getRegion(string $name): ?Region
  {
    return $this->regions[$name] ?? null;
  }
  
  public function getRegionInPosition(Position $position): ?Region
  {
    foreach($this->regions as $region) {
      if ($region->isInside($position)) {
        return $region;
      }
    }
    return null;
  }
  
  public function getRegionsInPosition(Position $position): array
  {
    $regions = [];
    foreach($this->regions as $region) {
      if (!$region->isInside($position)) {
        continue;
      }
      $regions[] = $region;
    }
    return $regions;
  }
  
  public function setCreator(string $username, string $name, RegionData $regionData = null): void
  {
    if ($this->isCreator($username)) {
      //texto aqui
      return;
    }
    $this->creators[$username] = new RegionCreator($username, $name, $regionData);
  }
  
  public function isCreator(string $username): bool
  {
    return isset($this->creators[$username]);
  }
  
  public function deleteCreator(string $username): void
  {
    if (!$this->isCreator($username)) {
      //texto aqui
      return;
    }
    unset($this->creators[$username]);
  }
  
  public function getCreators(): array
  {
    return $this->creators;
  }
  
  public function getCreator(string $username): ?RegionCreator
  {
    return $this->creators[$username] ?? null;
  }
  
}
