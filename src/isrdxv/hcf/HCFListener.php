<?php

namespace isrdxv\hcf;

use isrdxv\hcf\manager\SessionManager;

use pocketmine\event\{
  Listener,
  player\PlayerQuitEvent,
  player\PlayerJoinEvent,
  player\PlayerLoginEvent
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
    $session = SessionManager::getInstance()->get($player->getName());
    if ($session->getScoreboard() !== null) {
      $session->getScoreboard()->init();
    }
    $player->teleport(Server::getInstance()->getWorldManager()->getDefaultWorld()->getSafeSpawn());
    $event->setJoinMessage("§0[§a+§0] §a{$player->getName()}");
  }
  
  public function onQuit(PlayerQuitEvent $event): void
  {
    $player = $event->getPlayer();
    SessionManager::getInstance()->delete($player->getName());
    $event->setQuitMessage("§0[§c-§0] §c{$player->getName()}");
  }
  
}
