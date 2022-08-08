<?php

namespace isrdxv\hcf\utils;

use pocketmine\network\mcpe\protocol\UpdateBlockPacket;
use pocketmine\network\mcpe\protocol\types\BlockPosition;
use pocketmine\network\mcpe\convert\RuntimeBlockMapping;
use pocketmine\block\Block;
use pocketmine\world\Position;
use pocketmine\math\Vector3;

class BlocksHCF
{
  /**
   * createTower($player, $block->getId(), $block->getPosition());
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
  
  /**
   * createWall($world, $pos, GLASS());
   */
  public function createWall(Player $player, Vector3 $region, Block $block): void
  {
    if ($block instanceof Air) {
      return;
    }
    $coord = null;
    for($x = $player->getPosition()->x; $x <= $region->x; $x++) {
      for($y = $player->getPosition()->y; $y <= $region->y; $y++) {
        for($z = $player->getPosition()->z; $z <= $region->z; $z++) {
          $coord = new Vector3($x, $y, $z);
        }
      }
    }
    if (empty($coord)) {
      return;
    }
    $player->getWorld()->setBlock($coord, $block);
  }
  
}
