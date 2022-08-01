<?php

/*
*   ___ ___  ___ _      _  _   _
*  / __| _ \/ __| |    /_\| | | |
*  \__ \   / (__| |__ / _ \ |_| |
*  |___/_|_\\___|____/_/ \_\___/
*
* @author: iSrDxv (SrClau)
* @status: Stable
*/

namespace libs\scoreboard;

use isrdxv\hcf\HCFLoader;
use isrdxv\hcf\manager\TaskManager;

use pocketmine\player\Player;
use pocketmine\network\mcpe\protocol\ {
    SetDisplayObjectivePacket,
    SetScorePacket,
    SetScoreboardIdentityPacket,
    RemoveObjectivePacket
};
use pocketmine\network\mcpe\protocol\types\ScorePacketEntry;

class Scoreboard
{

  public static function create(Player $player, string $title): self
  {
    $self = new self($player);
    $self->title = $title;
    return $self;
  }

  /** @var Player **/
  public Player $player;

  public string $title;

  private $taskUpdater;

  /** @var ScorePacketEntry[] **/
  public array $lines = [];

  public function __construct(Player $player)
  {
    $this->player = $player;
  }
  
  /**
   * @return Player
   */
  public function getPlayer()
  {
    return $this->player;
  }

  /**
   * @return void
   */
  public function init()
  {
    $this->spawn();
    TaskManager::getInstance()->set(new ScoreboardTask($this), 20);
  }
  
  /**
   * @return void
   */
  public function spawn()
  {
    $pk = SetDisplayObjectivePacket::create(SetDisplayObjectivePacket::DISPLAY_SLOT_SIDEBAR, $this->player->getName(), $this->title, "dummy", SetDisplayObjectivePacket::SORT_ORDER_ASCENDING);
    $this->player->getNetworkSession()->sendDataPacket($pk);
  }
  /**
   * @return void
   */
  public function remove()
  {
    $pk = RemoveObjectivePacket::create($this->player->getName());
    $this->player->getNetworkSession()->sendDataPacket($pk);
  }

  /**
   * @return void
   */
  public function setLine(int $line, string $description = "")
  {
    $entry = new ScorePacketEntry();
    $entry->type = ScorePacketEntry::TYPE_FAKE_PLAYER;

    $entry->scoreboardId = $line;
    $entry->score = $line;
    $entry->customName = $description;
    $entry->objectiveName = $this->player->getName();

    $pk = new SetScorePacket();
    $pk->type = SetScorePacket::TYPE_CHANGE;
    $pk->entries[] = $entry;
    
    $this->player->getNetworkSession()->sendDataPacket($pk);
  }
  
  /**
   * @return void
   */
  public function setAllLine(array $values)
  {
    if (!$this->player->isOnline()) {
      return;
    }
    $this->remove();
    $this->spawn();
    $lines[0] = "";
    while(count($values) > 12) {
      array_shift($values);
    }
    foreach($values as $value) {
      $lines[] = " " . $value;
    }
    $lines[] = " §7" . HCFLoader::getInstance()->getConfig()->get("server-address");
    $lines[] = "§r";
    $line = 0;
    foreach($lines as $description) {
      $this->setLine($line, $description);
      ++$line;
    }
  }

  /**
   * @return void
   */
  public function removeLine(int $id)
  {
    $pk = new SetScorePacket();
    $pk->type = SetScorePacket::TYPE_REMOVE;
    $pk->entries[] = $this->lines[$id];
    $this->player->getNetworkSession()->sendDataPacket($pk);
  }

  public function removeAllLine()
  {
    if (count($this->lines) === 0) return;
    for ($i = 0; $i <= count($this->lines); $i++) {
      if (isset($this->lines[$i])) $this->removeLine($i);
    }
  }

}
