<?php

namespace isrdxv\hcf\entity;

use isrdxv\hcf\HCFLoader;
use isrdxv\hcf\entity\Entity;
use isrdxv\hcf\entity\utils\TagEditor;

use pocketmine\player\Player;

class NPC extends Entity
{
  private array $viewers = [];
  
  public function spawnTo(Player $player): void
  {
    parent::spawnTo($player);
    if (!in_array(spl_object_hash($player), $this->viewers)) {
      $this->viewers[spl_object_hash($player)] = $player;
    }
  }
  
  public function despawnFrom(Player $player): void
  {
    parent::despawnFrom($player);
    unset($this->viewers[spl_object_hash($player)]);
  }
  
  public function isViewer(Player $player): bool
  {
    return array_key_exists(spl_object_hash($player), $this->viewers);
  }
  
  public function getViewers(): array
  {
    return $this->viewers;
  }
  
  public function executeEmote(string $emoteId, bool $noStop = false, int $second): void
  {
    if ($noStop === false) {
      HCFLoader::getInstance()->scheduleRepeatingTask(new EmoteRepeatingTimer($emoteId, $this, $second), 20);
    } else {
      HCFLoader::getInstance()->scheduleRepeatingTask(new EmoteRepeating($emoteId, $this, $second), 20);
    }
  }
  
  public function toArray(): array
  {
    return parent::toArray();
  }
  
}
