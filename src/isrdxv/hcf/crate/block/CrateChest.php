<?php

namespace isrdxv\hcf\crate\block;

use isrdxv\hcf\crate\Crate;

use muqsit\invmenu\InvMenu;

use pocketmine\block\{
  Chest,
  BlockLegacyIds,
  BlockBreakInfo,
  BlockToolType,
  BlockIndentifier
};
use pocketmine\block\tile\Chest as TileChest;
use pocketmine\player\Player;
use pocketmine\item\ItemFactory;

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
    parent::__construct(new BlockIdentifier(BlockLegacyIds::CHEST, 0, null, TileChest::class), "CrateChest", new BlockBreakInfo(2.5, BlockToolType::AXE));
  }
  
  public function getBlockId(): array
  {
    return explode(":", $this->blockId);
  }
  
  public function toShow(Player $player): void
  {
    $menu = InvMenu::create(InvMenu::TYPE_CHEST);
    $menu->setName($this->crate->getName());
    for($i = count($this->items) - 1; $i <= 52; $i++) {
      if (empty($this->items[$i])) {
        $this->items[$i] = ItemFactory::getInstance()->air();
      }
    }
    $menu->setContents($this->items);
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
