<?php

namespace isrdxv\hcf\manager;

use isrdxv\hcf\session\Session;

use pocketmine\utils\SingletonTrait;

class SessionManager
{
  use SingletonTrait;
  
  private array $sessions;
  
  public function set(string $username): void
  {
    if (isset($this->sessions[$username])) {
      return;
    }
    $this->sessions[$username] = new Session($username);
  }
  
  public function get(string $username): ?Session
  {
    return $this->sessions[$username] ?? null;
  }
  
  public function getAll(): array
  {
    return $this->sessions;
  }
  
}