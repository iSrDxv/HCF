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

class CrateChest
{
  private string $blockId;
  
  private Crate $crate;
  
  /** @var Item[] **/
  private array $items;
  
  public function __construct(string $blockId, Crate $crate)
  {
    $this->blockId = $blockId;
    $this->crate = $crate;
    parent::__construct(new BlockIdentifier(BlockLegacyIds::CHEST, 0, null, TileChest::class), "CrateChest", new BlockBreakInfo(2.5, BlockToolType::AXE));
  }
  
  public function toShow(Player $player): void
  {
    $menu = InvMenu::create(InvMenu::TYPE_CHEST);
  }
  
  public function toUse(Player $player): void
  {
    
  }
  
}
