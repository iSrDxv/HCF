<?php

namespace isrdxv\hcf\crate;

use isrdxv\hcf\entity\FloatingText;

use pocketmine\block\VanillaBlocks;
use pocketmine\world\Position;
use pocketmine\Server;

class Crate
{
  private string $name;
  
  private string $customName;
  
  private array $tags;
  
  private string $keyName;
  
  private string $keyLore;
  
  private CrateChest $block;

  private FloatingText $floatingText;
  
  public function __construct(string $name, string $customName, array $tags, string $blockId, array $position, array $items, string $keyName, array $keyLore = [])
  {
    if (empty($name)) {
      throw new \RuntimeException("El nombre esta vacio :(");
    }
    $this->name = $name;
    $this->customName = $customName;
    $this->tags = $tags;
    $this->block = new CrateChest($blockId, $items);
    $this->position = Result::decodePosition($position);
    $this->keyName = $keyName;
    $this->keyLore = $keyLore;
    $this->floatingText = new FloatingText();
  }
  
  public function getName(): string
  {
    return $this->name;
  }
  
  public function getBlock(): CrateChest
  {
    return $this->block;
  }
  
  public function getCustomName(): string
  {
    return $this->customName;
  }
  
  public function getFloatingText(): FloatingText
  {
    return $this->floatingText;
  }
  
  public function getCrateKey(int $count = 1): Key
  {
    if ($this->keyName === null || $this->keyLore === null) {
      return;
    }
    //131,0
    $key = new Key($this->name);
    return $key->setCount($count)->setCustomName($this->keyName)->setLore($this->keyLore)->setCrateName($this->name);
  }
  
  public function spawn(): bool
  {
    if (!$this->position instanceof Position) {
      return false;
    }
    $this->position->getWorld()->setBlock($this->position, VanillaBlocks::CHEST());
    
    $this->floatingText->setPosition(Position::fromObject($this->position->subtract(0, 1, 0)->add(0.5, 1.5, 0.5), $this->position->getWorld()));
    foreach($this->tags as $tag) {
      $this->tagEditor->putLine($tag);
    }
    foreach(Server::getInstance()->getOnlinePlayers() as $player) {
      if ($player->getWorld()->getFolderName() === Server::getInstance()->getWorldManager()->getDefaultWorld()->getFolderName()) {
        $this->floatingText->spawnTo($player);
      }
    }
    return true;
  }
  
  public function respawn(Player $player): void
  {
    $this->floatingText->spawnTo($player);
    $this->spawn();
  }
  
}
