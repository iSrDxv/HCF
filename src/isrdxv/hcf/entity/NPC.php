<?php

namespace isrdxv\hcf\entity;

use isrdxv\hcf\entity\utils\TagEditor;

use pocketmine\entity\Human;
use pocketmine\player\Player;

class NPC extends Human
{
  /** @var TagEditor **/
  private $tagEditor;
  
  public function __construct($location, $skin, $nbt = null)
  {
    parent::__construct($location, $skin, $nbt);
    $this->tagEditor = new TagEditor($this);
  }
  
  public function getTagEditor(): TagEditor
  {
    return $this->tagEditor;
  }
  
  public function spawnTo(Player $player): void
  {
    $this->setImmobile();
    parent::spawnTo($player);
    foreach($this->tagEditor->getLines() as $line) {
      $line->spawnTo($player);
    }
  }
  
  public function toArray(): array
  {
    return parent::toArray();
  }
  
}
