<?php

namespace isrdxv\hcf\session;

use isrdxv\hcf\HCFLoader;

use pocketmine\player\Player;
use pocketmine\Server;

use libs\cooldown\CooldownManager;
use libs\scoreboard\Scoreboard;

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
      $this->scoreboard = Scoreboard ::create($this->getPlayer(), HCFLoader::getInstance()->getConfig()->get("server-name"));
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