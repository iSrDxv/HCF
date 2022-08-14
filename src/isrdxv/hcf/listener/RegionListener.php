<?php

namespace isrdxv\hcf\listener;

use isrdxv\hcf\HCFLoader;

use pocketmine\event\{
  Listener,
  player\PlayerExhaustEvent,
  block\BlockBreakEvent,
  block\BlockPlaceEvent,
  entity\EntityDamageEvent
};

class RegionListener implements Listener
{
  private HCFLoader $loader;
  
  public function __construct($loader)
  {
    $this->loader = $loader;
  }
  
  public function onExhaust(PlayerExhaustEvent $event): void
  {
    $player = $event->getPlayer();
    $region = $this->loader->getRegionManager()->getRegionInPosition($player->getPosition());
    if ($region !== null) {
      if ($region->getHungerRule() !== true) {
        $event->setCancelled();
      }
    }
  }
  
  public function onDamage(EntityDamageEvent $event): void
  {
    $entity = $event->getEntity();
    $region = $this->loader->getRegionManager()->getRegionInPosition($entity->getPosition());
    if ($region !== null) {
      if ($region->getPvpRule() !== true) {
        $event->setCancelled();
      }
    }
  }
    
}