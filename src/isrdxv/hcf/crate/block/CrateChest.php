<?php

namespace isrdxv\hcf\crate\block;

use isrdxv\hcf\crate\Crate;

use muqsit\invmenu\InvMenu;

use pocketmine\player\Player;
use pocketmine\item\ItemFactory;

/**
 * Imaginary chest (don't believe it's real xd)
 */
class CrateChest
{
  private string $blockId;
  
  private Crate $crate;
  
  /** @var Item[] **/
  private array $items = [];
  
  public function __construct(string $blockId, Crate $crate)
  {
    $this->blockId = $blockId;
    $this->crate = $crate;
  }
  
  public function getBlockId(): array
  {
    return explode(":", $this->blockId);
  }
  
  public function getItems(): array
  {
    return $this->items;
  }
  
  public function toShow(Player $player): void
  {
    $menu = InvMenu::create(InvMenu::TYPE_CHEST);
    $menu->setName($this->crate->getName());
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
