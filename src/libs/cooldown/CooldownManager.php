<?php

namespace libs\cooldown;

use libs\cooldown\Cooldown;

use Closure;

class CooldownManager
{
  /** @var Cooldown[] */
  protected array $cooldowns = [];
  
  public function set(string $cooldownName, int $duration, Closure $inCooldown, Closure $noCooldown): void
  {
    if (isset($this->cooldowns[$cooldownName])) {
      return;
    }
    $this->cooldowns[$cooldownName] = new Cooldown($cooldownName, $duration, $inCooldown, $noCooldown);
  }
  
  public function get(string $cooldownName): ?Cooldown
  {
    return $this->cooldowns[$cooldownName] ?? null;
  }
  
  public function delete(string $cooldownName): void
  {
    if (!empty($cooldown = $this->cooldowns[$cooldownName])) {
      unset($cooldown);
    }
  }
  
  public function getCooldowns(): array
  {
    return $this->cooldowns;
  }
  
}