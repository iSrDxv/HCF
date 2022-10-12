<?php

namespace isrdxv\hcf\crate\block;

use isrdxv\hcf\crate\Crate;

use pocketmine\player\Player;
use pocketmine\item\ItemFactory;

/**
 * Imaginary chest (don't believe it's real xd)
 */
class BlockCrate
{
  private string $blockId;
  
  /** @var Item[] **/
  private array $items = [];
  
  public function __construct(string $blockId)
  {
    $blockId = explode(":", $blockId);
    $this->id = $blockId[0];
    $this->meta = $blockId[1];
  }
  
  public function getId(): int
  {
    return $this->id;
  }
  
  public function getMeta(): int
  {
    return $this->meta;
  }
  
  public function toShow(Player $player): void
  {
    for($i = count($this->items) - 1; $i <= 26; $i++) {
      if (empty($this->items[$i])) {
        $this->items[$i] = ItemFactory::getInstance()->air();
      }
    }
    foreach($this->items as $item) {
      $menu->getInventory()->addItem($item);
    }
    $menu->setListener(InvMenu::readonly());
    $menu->send($player);
  }
  
  public function toUse(Player $player): void
  {
    if (count($this->items) === 0) {
      return;
    }
    $item = $this->items[array_rand($this->items)];
    $player->getInventory()->addItem($item);
  }
  
}
