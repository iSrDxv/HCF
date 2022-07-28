<?php

namespace isrdxv\hcf\utils;

use pocketmine\network\mcpe\protocol\UpdateBlockPacket;
use pocketmine\network\mcpe\protocol\types\BlockPosition;
use pocketmine\network\mcpe\convert\RuntimeBlockMapping;
use pocketmine\block\VanillaBlocks;
use pocketmine\world\Position;

class BlocksHCF
{
  /**
   * createTower($player, $blockId, $block->getPosition());
   */
  public function createTower(Player $player, int $blockId, Position $position): void
  {
    for($y = $position->getY(); $y < $position->getY() + 10; $y++) {
      if (!$position->getWorld()->getBlock(($position = $position->add(0, $y, 0))) instanceof Air) {
        continue;
      }
      $pk = UpdateBlockPacket::create(BlockPosition::fromVector3($position), RuntimeBlockMapping::getInstance()->toRuntimeId($blockId), UpdateBlockPacket::FLAG_NETWORK, UpdateBlockPacket::DATA_LAYER_NORMAL);
      $player->getNetworkSession()->sendDataPacket($pk);
    }
  }
  
  public function createWall(): void;
  
}