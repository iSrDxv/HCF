<?php

namespace isrdxv\hcf;

use isrdxv\hcf\HCFLoader;
use isrdxv\hcf\manager\SessionManager;
use isrdxv\hcf\player\HCFPlayer;
use pocketmine\event\{
  Listener,
  player\PlayerQuitEvent,
  player\PlayerJoinEvent,
  player\PlayerPreLoginEvent,
  player\PlayerLoginEvent,
  world\ChunkLoadEvent
};
use pocketmine\event\player\PlayerCreationEvent;
use pocketmine\Server;
use pocketmine\player\{
  PlayerInfo,
  XboxLivePlayerInfo
};

class HCFListener implements Listener
{
  private HCFLoader $loader;
  
  public function __construct(HCFLoader $loader)
  {
    $this->loader = $loader;
  }
  
  function registerClass(PlayerCreationEvent $event): void
  {
    $event->setPlayerClass(HCFPlayer::class);
  }

  public function onPreLogin(PlayerPreLoginEvent $event): void
  {
    $playerInfo = $event->getPlayerInfo();
    if ($event->isKickFlagSet(PlayerPreLoginEvent::KICK_FLAG_SERVER_WHITELISTED)) {
      $event->setKickFlag(PlayerPreLoginEvent::KICK_FLAG_SERVER_WHITELISTED, "§l§The server is under maintenance");
    }
    if ($event->isKickFlagSet(PlayerPreLoginEvent::KICK_FLAG_SERVER_FULL)) {
      if (!in_array($playerInfo->getUsername(), $this->loader->getConfig()->get("server-bypass"), true)) {
        return;
      }
      $event->clearKickFlag(PlayerPreLoginEvent::KICK_FLAG_SERVER_FULL);
    }
    if (!$playerInfo instanceof XboxLivePlayerInfo) {
      $event->setKickFlag(PlayerPreLoginEvent::KICK_FLAG_PLUGIN, "§l§cPlease log in to Xbox Live before entering the server, thanks :)");
      return;
    }
  }
  
  public function onLogin(PlayerLoginEvent $event): void
  {
    $player = $event->getPlayer();
    if (!$player instanceof HCFPlayer) {
      //$event->setKickMessage();
      return;
    }
  }
  
  public function onJoin(PlayerJoinEvent $event): void
  {
    $player = $event->getPlayer();
    if (!$player instanceof HCFPlayer) {
      return;
    }
    //$event->setJoinMessage("§0[§a+§0] §a{$player->getName()}");
    if ($player->getScoreboard() !== null) {
      $player->getScoreboard()->init();
    }
    if (!$player->hasPlayedBefore()) {
      $player->teleport(Server::getInstance()->getWorldManager()->getDefaultWorld()->getSpawnLocation(), $player->getEyeHeight(), $player->getEyeHeight());
    }
  }
  
  public function onQuit(PlayerQuitEvent $event): void
  {
    $player = $event->getPlayer();
    $event->setQuitMessage("§0[§c-§0] §c{$player->getName()}");
  }
  
  public function onChunkLoad(ChunkLoadEvent $event): void
  {
    $world = Server::getInstance()->getWorldManager()->getDefaultWorld();
    $limitX = $world->getSpawnLocation()->getFloorX() + $this->loader->getMapBorder() >> 4;
    $limitZ = $world->getSpawnLocation()->getFloorZ() + $this->loader->getMapBorder() >> 4;
    $subtractLimitX = $world->getSpawnLocation()->getFloorX() + -$this->loader->getMapBorder() >> 4;
    $subtractLimitZ = $world->getSpawnLocation()->getFloorZ() + -$this->loader->getMapBorder() >> 4;
    if (($event->getChunkX() >> 4) > $limitX || ($event->getChunkZ() >> 4) > $limitZ) {
      $world->unloadChunk($event->getChunkX(), $event->getChunkZ());
    }
    if (($event->getChunkX() >> 4) > $subtractLimitX || ($event->getChunkZ() >> 4) > $subtractLimitZ) {
      $world->unloadChunk($event->getChunkX(), $event->getChunkZ());
    }
    var_dump($limitX);
    var_dump($subtractLimitX);
  }
  
}