<?php

namespace hcf\listeners;

use pocketmine\utils\TextFormat as TE;
use pocketmine\event\{
  Listener,
  player\PlayerJoinEvent,
  player\PlayerQuitEvent\
  player\PlayerInteracgEvent,
  player\PlayerCreationEvent
};

use pocketmine\Server;

use hcf\PlayerHCF;

class PlayerListener extends Listener 
{
  
  public function joinEvent(PlayerJoinEvent $event): void
  {
    $player = $event->getPlayer();
    $name = $player->getName();
    
    $joinMessage = str_replace("%name%", $name, $this->getConfig()->get("joinMessage"));
    $event->setJoinMessage($joinMessage);
 }
  
  public function quitEvent(PlayerQuitEvent $event): void
  {
    $player = $event->getPlayer();
    $name = $player->getName();
    
    $quitMessage = str_replace("%name%", $name, $this->getConfig()->get("quitMessage"));
    $event->setQuitMessage($quitMessage);
  }
  
  public function creation(PlayerCreationEvent $event): void 
  {
    if ($event->getPlayerClass() === PlayerHCF::class) {
      return;
    }
    $event->setPlayerClass(PlayerHCF::class);
  }
  
}
