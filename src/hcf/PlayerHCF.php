<?php

namespace hcf;

use pocketmine\player\Player;

class PlayerHCF extends Player
{
  public const PUBLIC_CHAT = "public"; public const STAFF_CHAT = "staff_chat"; public const FACTION_CHAT = "faction_chat"; 

  private $enderPearl = 0 ;
  
  private $goldenApple = 0;
  
  private ?Faction $faction;
  
  private string $factionRole = "null";
  
  public function setFaction(Faction $faction): void
  {
    $this->faction = $faction;
    $sql = SQLite3Provider::getDatabase()->prepare("INSERT INTO players(username, factionName) VALUES (:username, :factionName);");
    $sql->bindParam(":username", $this->getName());
    $sql->bindParam(":factionName", $faction->getName());
    $sql->execute();
  }
  
  public function setFactionRank(string $rank): void
  {
    $this->factionRole = $rank;
    $sql = SQLite3Provider::getDatabase()->prepare("UPDATE players SET factionRank = :factionRank WHERE username = :username;");
    $sql->bindParam(":username", $this->getName());
    $sql->bindParam(":factionRank", $rank);
    $sql->execute();
  }
  
  public function getFaction(): Faction
  {
    return $this->faction;
  }
  
  public function getFactionRole(): string
  {
    return $this->factionRole;
  }
  
}
