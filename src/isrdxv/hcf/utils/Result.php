<?php

namespace isrdxv\hcf\utils;

use pocketmine\item\Item;
//use pocketmine\nbt\tag\CompoundTag;

class Result
{
  
  public static function encodeItem(Item $item): array
  {
    return $item->jsonSerialize();
  }
  
  public static function encodeItems(array $contents): array
  {
    if (empty($contents)) {
      return [];
    }
    $data = [];
    foreach($contents as $slot => $item) {
      $data[$slot] = $item->jsonSerialize();
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
      $items[] = $item->jsonSerialize();
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