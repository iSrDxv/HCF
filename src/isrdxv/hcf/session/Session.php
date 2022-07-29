<?php

namespace isrdxv\hcf\session;

use pocketmine\player\Player;
use pocketmine\Server;

class Session
{
  private string $username;
  
  public function __construct(string $username)
  {
    $this->username = $username;
  }
  
  public function getPlayer(): ?Player
  {
    return Server::getInstance()->getPlayerByPrefix($this->username);
  }
  
}