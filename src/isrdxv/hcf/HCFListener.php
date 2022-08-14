<?php

namespace isrdxv\hcf;

use isrdxv\hcf\HCFLoader;
use isrdxv\hcf\manager\SessionManager;

use pocketmine\event\{
  Listener,
  player\PlayerQuitEvent,
  player\PlayerJoinEvent,
  player\PlayerLoginEvent,
  world\ChunkLoadEvent
};
use pocketmine\Server;

class HCFListener implements Listener
{
  
  public function onLogin(PlayerLoginEvent $event): void
  {
    $player = $event->getPlayer();
    SesssionManager::getInstance()->set($player->getName());
  }
  
  public function onJoin(PlayerJoinEvent $event): void
  {
    $player = $event->getPlayer();
    $event->setJoinMessage("§0[§a+§0] §a{$player->getName()}");
    $session = SessionManager::getInstance()->get($player->getName());
    if ($session->getScoreboard() !== null) {
      $session->getScoreboard()->init();
    }
    $player->teleport(Server::getInstance()->getWorldManager()->getDefaultWorld()->getSafeSpawn());
  }
  
  public function onQuit(PlayerQuitEvent $event): void
  {
    $player = $event->getPlayer();
    $event->setQuitMessage("§0[§c-§0] §c{$player->getName()}");
    SessionManager::getInstance()->delete($player->getName());
  }
  
  public function onChunkLoad(ChunkLoadEvent $event): void
  {
    $border = HCFLoader::getInstance()->getConfig()->getNested("map-border");
    $world = Server::getInstance()->getWorldManager()->getDefaultWorld();
    $limitX = $world->getSpawnLocation()->getFloorX() + $border >> 4;
    $limitZ = $world->getSpawnLocation()->getFloorZ() + $border >> 4;
    $subtractLimitX = $world->getSpawnLocation()->getFloorX() + -$border >> 4;
    $subtractLimitZ = $world->getSpawnLocation()->getFloorZ() + -$border >> 4;
    if (($event->getChunkX() >> 4) > $limitX || ($event->getChunkZ() >> 4) > $limitZ) {
      $world->unloadChunk($event->getChunkX(), $event->getChunkZ());
    }
    if (($event->getChunkX() >> 4) > $subtractLimitX || ($event->getChunkZ() >> 4) > $subtractLimitZ) {
      $world->unloadChunk($event->getChunkX(), $event->getChunkZ());
    }
  }
  
}