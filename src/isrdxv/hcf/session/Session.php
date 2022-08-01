<?php

namespace isrdxv\hcf\session;

use pocketmine\player\Player;
use pocketmine\Server;

use libs\cooldown\CooldownManager;

class Session
{
  private string $username;
  
  private ?CooldownManager $cooldown = null;
  
  private ?Scoreboard $scoreboard;
  
  public function __construct(string $username)
  {
    $this->username = $username;
    if (empty($this->cooldown)) {
      $this->cooldown = new CooldownManager();
    }
    if (empty($this->scoreboard)) {
      $this->scoreboard = new Scoreboard ($this->getPlayer());
      $this->scoreboard->title = "test";
    }
  }
  
  public function getPlayer(): ?Player
  {
    return Server::getInstance()->getPlayerByPrefix($this->username);
  }
  
  public function getCooldown(): CooldownManager
  {
    return $this->cooldown;
  }
  
  public function getScoreboard(): ?Scoreboard
  {
    return $this->scoreboard ?? null;
  }
  
}
