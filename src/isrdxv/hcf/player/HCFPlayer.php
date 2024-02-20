<?php

namespace isrdxv\hcf\player;

use isrdxv\hcf\HCFLoader;
use isrdxv\hcf\faction\Faction;

use pocketmine\player\Player;
use pocketmine\Server;

use exodus\cooldown\CooldownManager;
use exodus\scoreboard\Scoreboard;
use exodus\cache\CacheManager;
use pocketmine\entity\Location;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\network\mcpe\NetworkSession;
use pocketmine\player\PlayerInfo;

class HCFPlayer extends Player
{
  private string $username;
  
  private ?string $factionRole = null;
  
  private CooldownManager $cooldown;
  
  private Scoreboard $scoreboard;
  
  //private CacheManager $cache;
  
  private ?Faction $faction;
  
  public function __construct(Server $server, NetworkSession $session, PlayerInfo $playerInfo, bool $authenticated, Location $location, ?CompoundTag $namedtag)
  {
    parent::__construct($server, $session, $playerInfo, $authenticated, $location, $namedtag);
    if (empty($this->cooldown)) {
      $this->cooldown = new CooldownManager();
    }
    if (empty($this->scoreboard)) {
      $this->scoreboard = Scoreboard ::create($this, HCFLoader::getInstance()->getConfig()->get("server-name"));
    }
    /*if (empty($this->cache)) {
      $this->cache = new CacheManager();
    }*/
  }
  
  public function getCooldown(): CooldownManager
  {
    return $this->cooldown;
  }
  
  public function getScoreboard(): ?Scoreboard
  {
    return $this->scoreboard;
  }
  
  /*public function getCache(): CacheManager
  {
    return $this->cache;
  }*/
  
  public function getFaction(): ?Faction
  {
    return $this->faction ?? null;
  }
  
  public function setFaction(?Faction $faction = null): void
  {
    $this->faction = $faction;
  }
  
  public function getFactionRole(): ?string
  {
    return $this->factionRole ?? null;
  }
  
  public function setFactionRole(?string $factionRole = null): void
  {
    $this->factionRole = $factionRole;
  }
  
}
