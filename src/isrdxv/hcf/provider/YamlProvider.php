<?php

namespace isrdxv\hcf\provider;

use isrdxv\hcf\HCFLoader;

use pocketmine\utils\Config;

class YamlProvider implements Provider
{
  public const PREFIX = "[Provider YAML]";
  
  private HCFLoader $loader;
  
  public function __construct(HCFLoader $loader)
  {
    $this->loader = $loader;
  }
  
  public function set(string $archive, string|int $key, mixed $value): void
  {
    try {
      $config = new Config($this->loader->getDataFolder() . $archive, Config::YAML);
      $config->setNested($key, $value);
      $config->save();
    } catch(\Exception $exception) {
      $this->loader->getLogger()->error(self::PREFIX . " Exception: " . $exception->getMessage());
    }
  }
  
  public function setAll(string $archive, array $values): void
  {
    try {
      $config = new Config($this->loader->getDataFolder() . $archive, Config::YAML);
      $config->setAll($values);
      $config->save();
    } catch(Exception $exception) {
      $this->loader->getLogger()->error(self::PREFIX . " Exception: " . $exception->getMessage());
    }
  }
  
  public function get(string $archive, string|int $key): mixed
  {
    try {
      $config = new Config($this->loader->getDataFolder() . $archive, Config::YAML);
      return $config->getNested($key);
    } catch(Exception $exception) {
      $this->loader->getLogger()->error(self::PREFIX . " Exception: " . $exception->getMessage());
    }
  }
  
  public function getAll(string $archive): array
  {
    try {
      $config = new Config($this->loader->getDataFolder() . $archive, Config::YAML);
      return $config->getAll();
    } catch(Exception $exception) {
      $this->loader->getLogger()->error(self::PREFIX . " Exception: " . $exception->getMessage());
    }
  }
  
  public function exists(string $archive, string $key): bool
  {
    try {
      $config = new Config($this->loader->getDataFolder() . $archive, Config::YAML);
      return $config->exists($key);
    } catch(Exception $exception) {
      $this->loader->getLogger()->error(self::PREFIX . " Exception: " . $exception->getMessage());
    }
  }
  
}