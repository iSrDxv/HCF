<?php

namespace isrdxv\hcf\crate;

use isrdxv\hcf\crate\block\BlockCrate;
use isrdxv\hcf\entity\FloatingText;
use isrdxv\utils\Utils;

use muqsit\invmenu\InvMenu;

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
  
  private BlockCrate $block;

  private InvMenu $menu;
  
  private FloatingText $floatingText;
  
  public function __construct(string $name, string $customName, array $tags, string $blockId, array $position, array $items, string $keyName, array $keyLore = [])
  {
    if (empty($name)) {
      throw new \RuntimeException("El nombre esta vacio :(");
    }
    $this->name = $name;
    $this->customName = $customName;
    $this->tags = $tags;
    $this->block = new BlockCrate($blockId);
    $this->position = Utils::decodePosition($position);
    $this->keyName = $keyName;
    $this->keyLore = $keyLore;
    $this->menu = InvMenu::create(InvMenu::TYPE_CHEST);
    $this->menu->setName($customName);
    $this->floatingText = new FloatingText();
  }
  
  public function getName(): string
  {
    return $this->name;
  }
  
  public function getCustomName(): string
  {
    return $this->customName;
  }
  
  public function getMenu(): InvMenu
  {
    return $this->menu;
  }
  
  public function getBlock(): BlockCrate
  {
    return $this->block;
  }
    
  public function getFloatingText(): FloatingText
  {
    return $this->floatingText;
  }
  
  public function getItems(): array
  {
    return $this->items;
  }
  
  public function setItems(array $items): void
  {
    $this->items = $items;
    for ($i = 0; $i <= $this->menu->getInventory()->getSize() - 1; $i++) {
      $item = VanillaBlocks::STAINED_GLASS();
      if (isset($items)) {
        $item = array_unshift($items);
      }
      $this->menu->getInventory()->setItem($i, $item);
    }
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
  
  public function despawn(): void
  {
    
  }
  
  public function save(): void
  {
    
  }
}