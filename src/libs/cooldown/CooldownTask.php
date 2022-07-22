<?php

namespace libs\cooldown;

use Closure;

use pocketmine\scheduler\Task;

class CooldownTask extends Task
{
  protected int $duration;
  
  protected Closure $inCooldown;
  
  protected Closure $noCooldown;
  
  public function __construct(int $duration, Closure $inCooldown, Closure $noCooldown)
  {
    $this->duration = $duration;
    $this->inCooldown = $inCooldown;
    $this->noCooldown = $noCooldown;
  }
  
  public function onRun(): void
  {
    $this->duration--;
    ($this->inCooldown)($this->duration);
    if ($this->duration === 0) {
      ($this->noCooldown);
      $this->getHandler()->cancel();
    }
  }
  
}