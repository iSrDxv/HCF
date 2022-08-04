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
  
  public function __construct(string $name, string $customName, array $tags, string $blockId, array $position, array $items, string $keyName, array $keyLore)
  {
    if (empty($name)) {
      //code
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
  
  public function getCrateKey(): Key
  {
    if ($this->keyName === null || $this->keyLore === null) {
      return;
    }
    $key = new Key(new ItemIdentifier(54, 0), $this->name);
    $key->setCustomName($this->keyName);
    $key->setLore($this->keyLore);
    $key->setCrateName($this->name);
    return $key;
  }
  
  public function spawn(): bool
  {
    if (!$this->position instanceof Position) {
      return false;
    }
    $this->position->getWorld()->setBlock($this->position, VanillaBlocks::CHEST());
    
    $this->floatingText->setPosition($this->position->getX() + 0.5, ($this->position->getY() - 1) + 1.5, $this->position->getZ() + 0.5, $this->position->getWorld());
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
