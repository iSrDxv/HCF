<?php

namespace libs\cooldown;

use libs\cooldown\Cooldown;

use Closure;

use pocketmine\utils\Utils;

class CooldownManager
{
  /** @var Cooldown[] */
  protected array $cooldowns = [];
  
  public function set(string $cooldownName, int $duration, Closure $inCooldown, ?Closure $noCooldown = null): void
  {
    if (isset($this->cooldowns[$cooldownName])) {
      return;
    }
    Utils::validateCallableSignature(function(int $duration): void {}, $inCooldown);
    //Utils::validateCallableSignature(function(): void {}, $noCooldown);
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
