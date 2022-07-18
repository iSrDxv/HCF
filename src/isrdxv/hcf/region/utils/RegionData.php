<?php

namespace hcf\region\utils;

use pocketmine\world\World;

use hcf\region\utils\RegionPosition;

class RegionData
{
  public string $name;
  
  public string $custom_name = "";
  
  public bool $pvp_rule = true;
  
  public bool $block_rule = false;
  
  public bool $hunger_rule = false;
  
  public World $world;
  
  public ?RegionPosition $first_position = null;
  
  public ?RegionPosition $second_position = null;
}