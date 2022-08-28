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

namespace isrdxv\scoreboard;

use pocketmine\player\Player;

use pocketmine\network\mcpe\protocol\{

  SetDisplayObjectivePacket,

  SetScorePacket,

  SetScoreboardIdentityPacket,

  RemoveObjectivePacket

};

use pocketmine\network\mcpe\protocol\types\ScorePacketEntry;

class ScoreboardLib

{

  public static function create(Player $player, string $title): self

  {

    $self = new self($player);

    $self->title = $title; 

    return $self;

  }

  /** @var Player **/

  private Player $player;

  public string $title;

  private bool $spawned = false;

  /** @var ScorePacketEntry[] **/

  private array $lines = [];

  public function __construct(Player $player)

  {

  $this->player = $player;

  }

  public function getPlayer(): Player

  {

    return $this->player;

  }

  public function isSpawned(): bool

  {

    return $this->spawned;

  }

  

  public function spawn(): void 

  {

    if (!$this->player->isOnline()) {

      return;

    }

    if (!$this->spawned) {

      $pk = SetDisplayObjectivePacket::create(SetDisplayObjectivePacket::DISPLAY_SLOT_SIDEBAR, $this->player->getName(), $this->title, "dummy", SetDisplayObjectivePacket::SORT_ORDER_ASCENDING);

      $this->player->getNetworkSession()->sendDataPacket($pk);

      $this->spawned = true;

      return;

    }

  }

  

  public function remove(): void

  { 

    if (!$this->player->isOnline() || !$this->spawned) {

      return;

    }

    $this->spawned = false;

    $pk = RemoveObjectivePacket::create($this->player->getName());

    $this->player->getNetworkSession()->sendDataPacket($pk);

  }

  

  public function setLine(int $line, string $description = ""): void

  {

    $this->removeLine($line);

    $entry = new ScorePacketEntry();

    $entry->type = ScorePacketEntry::TYPE_FAKE_PLAYER;

    $entry->scoreboardId = $line;

    $entry->score = $line;

    $entry->customName = $description;

    $entry->objectiveName = $this->player->getName();

    $this->lines[$line] = $entry;

    

    $pk = SetScorePacket();

    $pk->type = SetScorePacket::TYPE_CHANGE;

    $pk->entries[] = $entry;

    $this->player->getNetworkSession()->sendDataPacket($pk);

  }

  public function removeLine(int $id = 0): void

  {

    if (isset($this->lines[$id])) {

      $pk = new SetScorePacket();

      $pk->type = SetScorePacket::TYPE_REMOVE; 

      $pk->entries[] = $this->lines[$id];

      $this->player->getNetworkSession()->sendDataPacket($pk);

      unset($this->lines[$id]);

    }

  }

  

  public function setAllLine(array $lines): void

  {

    for ($i = count($lines); $i <= 15; $i++) {

      if (isset($this->lines[$i])) {

        continue;

      }

      $this->setLine($i, $lines[$i]);

    }

  }

  public function removeAllLine(): void

  {

    if (!$this->player->isOnline() || empty($this->lines) && !$this->spawned) {

      return;

    }

    $pk = new SetScorePacket(SetScorePacket::TYPE_REMOVE, array_values($this->lines));

    $this->player->getNetworkSession()->sendDataPacket($pk);
    $this->lines = [];

  }

}