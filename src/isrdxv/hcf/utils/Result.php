<?php

namespace isrdxv\hcf\utils;

use pocketmine\item\Item;
//use pocketmine\nbt\tag\CompoundTag;

class Result
{
  
  public function encodeItem(Item $item): array
  {
    return $item->jsonSerialize();
  }
  
  public function encodeItems(array $contents): array
  {
    if (empty($contents)) {
      return;
    }
    $data = [];
    foreach($contents as $slot => $item) {
      $data[$slot] = $item->jsonSerialize();
    }
    return $data;
  }
  
  public function decodeItem(array $data): Item
  {
    return Item::jsonDeserealize($data);
  }
  
  public function decodeItems(array $contents): array
  {
    $items = [];
    foreach($contents as $slot => $data) {
      $items[$slot] = Item::jsonDeserealize($data);
    }
    return $items;
  }
  
  public static function decodeItemsContent(array $content): array
  {
    $content = [];
    foreach($content as $data) {
      $content[] = Item::jsonDeserealize($data);
    }
    return $content;
  }
  
}