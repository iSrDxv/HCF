<?php

namespace isrdxv\hcf\utils;

use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use pocketmine\nbt\{
  TreeRoot,
  LittleEndianNbtSerializer
};
use pocketmine\entity\Entity;
use pocketmine\item\Item;
//use pocketmine\nbt\tag\CompoundTag;

class Result
{
  
  public static function playSound(Entity $entity, string $sound, int $volume = 1, int $pitch = 1, int $radius = 3): void
  {
    foreach($entity->getWorld()->getNearbyEntities($entity->getBoundingBox()->expandedCopy($radius, $radius, $radius)) as $entities) {
      $pk = PlaySoundPacket::create($sound, $entities->getPosition()->x, $entities->getPosition()->y, $entities->getPosition()->z, $volume, $pitch);
      $entities->getNetworkSession()->sendDataPacket($entities);
    }
  }
  
  public static function encodeItem(Item $item): array
  {
    $array = [
      $item->getId()
    ];
    if ($item->getMeta() !== 0) {
      $array["damage"] = $item->getMeta();
    }
    if ($item->getCount() !== 1) {
      $array["count"] = $item->getCount();
    }
    if ($item->hasNamedTag()) {
      $array["nbt_64b"] = base64_encode((new LittleEndianNbtSerializer())->write(new TreeRoot($item->getNamedTag())));
    }
    return $array;
  }
  
  public static function encodeItems(array $contents): array
  {
    if (empty($contents)) {
      return [];
    }
    $data = [];
    foreach($contents as $slot => $item) {
      $data[$slot] = $this->encodeItem($item);
    }
    return $data;
  }
  
  public static function decodeItem(array $data): Item
  {
    return Item::jsonDeserealize($data);
  }
  
  public static function decodeItems(array $contents): array
  {
    if (empty($contents)) {
      return [];
    }
    $items = [];
    foreach($contents as $slot => $data) {
      $items[$slot] = Item::jsonDeserealize($data);
    }
    return $items;
  }
  
  public static function encodeInventoryContent(array $content): array
  {
    $items = [];
    foreach($content as $item) {
      $items[] = $this->encodeItem($item);
    }
    return $items;
  }
  
  public static function decodeInventoryContent(array $content): array
  {
    $items = [];
    foreach($content as $data) {
      $items[] = Item::jsonDeserealize($data);
    }
    return $content;
  }
  
}
