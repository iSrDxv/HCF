<?php

namespace libs\cache;

use libs\cache\Cache;

class CacheManager
{
  private array $caches = [];
  
  public function set(string $name, mixed $data): bool
  {
    if (empty($name) or isset($this->caches[$name])) {
      return false;
    }
    $this->caches[$name] = new Cache($data);
  }
  
  public function get(string $name): ?Cache
  {
    return $this->caches[$name] ?? null;
  }
  
  public function getAll(): array
  {
    return $this->caches;
  }
  
}
