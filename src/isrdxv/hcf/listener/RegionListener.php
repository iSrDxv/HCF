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
  
  public function onExhaust(PlayerExhaustEvent $event): void
  {
    $player = $event->getPlayer();
    $region = HCFLoader::getRegionManager()->getRegionInPosition($player->getPosition());
    if ($region !== null) {
      if ($region->getHungerRule() !== true) {
        $event->cancel();
      }
    }
  }
  
  public function onDamage(EntityDamageEvent $event): void
  {
    $entity = $event->getEntity();
    $region = HCFLoader::getRegionManager()->getRegionInPosition($entity->getPosition());
    if ($region !== null) {
      if ($region->getPvpRule() !== true) {
        $event->cancel();
      }
    }
  }
  
  public function onBreak(BlockBreakEvent $event): void
  {
    $player = $event->getPlayer();
    $region = HCFLoader::getRegionManager()->getRegionInPosition($player->getPosition());
    if ($region !== null) {
      if ($region->getBlockRule() !== true) {
        $event->cancel();
      }
    }
  }

  public function onPlace(BlockPlaceEvent $event): void
  {
    $player = $event->getPlayer();
    $region = HCFLoader::getRegionManager()->getRegionInPosition($player->getPosition());
    if ($region !== null) {
      if ($region->getBlockRule() !== true) {
        $event->cancel();
      }
    }
  }
  
}
