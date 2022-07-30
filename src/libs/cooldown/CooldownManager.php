<?php

namespace libs\cooldown;

use libs\cooldown\Cooldown;

use Closure;

class CooldownManager
{
  /** @var Cooldown[] */
  protected array $cooldowns = [];
  
  public function set(string $cooldownName, int $duration, Closure $inCooldown, ?Closure $noCooldown = null): void
  {
    if (isset($this->cooldowns[$cooldownName])) {
      return;
    }
    $this->cooldowns[$cooldownName] = new Cooldown($this, $cooldownName, $duration, $inCooldown, $noCooldown);
  }
  
  public function get(string $cooldownName): ?Cooldown
  {
    return $this->cooldowns[$cooldownName] ?? null;
  }
  
  public function delete(string $cooldownName): void
  {
    if (isset($this->cooldowns[$cooldownName])) {
      unset($this->cooldowns[$cooldownName]);
    }
  }
  
  public function getCooldowns(): array
  {
    return $this->cooldowns;
  }
  
}
