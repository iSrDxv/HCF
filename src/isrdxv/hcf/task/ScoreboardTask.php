<?php

namespace isrdxv\hcf\task;

use libs\scoreboard\Scoreboard;

use pocketmine\scheduler\Task;

class ScoreboardTask extends Task
{
  private Scoreboard $scoreboard;
  
  public function __construct(Scoreboard $scoreboard)
  {
    $this->scoreboard = $scoreboard;
  }
  
  public function onRun(): void
  {
    $player = $this->scoreboard->getPlayer();
    $session = SessionManager::getInstance()->get($player->getName());
    $cooldown = $session->getCooldown();
    $lines = [];
    if (($antiTrapper = $cooldown->get("Anti-trapper")) !== null) {
      $lines[] = "§bAnti Trapper: " . $antiTrapper->getDuration();
    }
    if (($combatTag = $cooldown->get("combat-tag")) !== null) {
      $lines[] = "§cCombat Tag: " . $combatTag->getDuration();
    }
    if (($prePearl = $cooldown->get("pre-pearl")) !== null) {
      $lines[] = "§ePre Pearl: " . $prePearl->getDuration();
    }
    if (($enderPearl = $cooldown->get("ender-pearl")) !== null) {
      $lines[] = "§9Ender Pearl: " . $enderPearl->getDuration();
    }
    $this->scoreboard->setAllLine($lines);
  }
  
}
