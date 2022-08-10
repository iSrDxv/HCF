<?php

namespace isrdxv\hcf\entity;

use isrdxv\hcf\entity\Entity;

use pocketmine\entity\Entity as PMEntity;
use pocketmine\world\Position;
use pocketmine\Server;

use Ramsey\Uuid\Uuid;

class FloatingText extends Entity
{
  private $entityId;
  
  /** @var TagEditor|null **/
  private $tagEditor;
  
  /** @var Position **/
  private $position;
  
  /** @var Float **/
  private $scale = 0.50;
  
  /** @var Bool **/
  private $spawned = false;
  
  public function __construct()
  {
    $this->uuid = Uuid::uuid4();
    $this->entityId = PMEntity::nextRuntimeId();
    $this->tagEditor = new TagEditor($this);
  }
  
  public function setScale(float $scale = 0.50): void
  {
    if (is_int($scale)) {
      return;
    }
    parent::setScale($scale);
  }
  
  public function getId(): int
  {
    return parent::getId();
  }
  
  public function getScale(): float
  {
    return parent::getScale();
  }
  
  public function setPosition(Position $position): void
  {
    if (!$position instanceof Position) {
      return;
    }
    parent::setPosition($position);
  }
  
  public function getPosition(): Position
  {
    return parent::getPosition();
  }
  
  public function spawnTo(Player $player): void
  {
    if ($this->spawned === false) {
      foreach($this->tagEditor->getLines() as $line) {
        $line->spawnTo($player);
        $this->spawned = true;
      }
    }
  }
  
  public function toArray(): array
  {
    return parent::toArray();
  }
  
}
