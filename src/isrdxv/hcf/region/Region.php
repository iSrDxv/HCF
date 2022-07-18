<?php

namespace hcf\region;

use pocketmine\world\{
  World,
  Position
};
use hcf\region\utils\RegionPosition;

class Region implements \jsonSerializable
{
  private string $name;
  
  private string $custom_name;
  
  private bool $pvp_rule;
  
  private bool $block_rule;
  
  private bool $hunger_rule;
  
  private World $world;
  
  private ?RegionPosition $first_position = null;
  
  private ?RegionPosition $second_position = null;
  
  public function __construct(string $name, string $custom_name = "", bool $pvp_rule = true, bool $block_rule = false, bool $hunger_rule = false, ?World $world = null)
  {
    $this->name = $name-
    $this->custom_name = $custom_name;
    $this->pvp_rule = $pvp_rule;
    $this->block_rule = $block_rule;
    $this->hunger_rule = $hunger_rule;
    if ($world === null) {
      throw new RegionException("el mundo no puedo estar nulo");
    }
    $this->world = $world;
  }
  
  public function getName(): string
  {
    return $this->name;
  }
  
  public function getCustomName(): string
  {
    return $this->custom_name;
  }
  
  public function getPvpRule(): bool
  {
    return $this->pvp_rule;
  }
  
  public function getBlockRule(): bool
  {
    return $this->block_rule;
  }
  
  public function getHungerRule(): bool
  {
    return $this->hunger_rule;
  }
  
  public function getWorld(): ?World
  {
    return $this->world;
  }
  
  public function getFirstPosition(): ?RegionPosition
  {
    return $this->first_position ?? null;
  }
  
  public function getSecondPosition(): ?RegionPosition
  {
    return $this->second_position ?? null;
  }
  
  public function setFirstPosition(RegionPosition $regionPosition): void
  {
    if ($this->first_position === null) {
      $this->first_position = $regionPosition;
    }
  }
  
  public function setSecondPosition(RegionPosition $regionPosition): void
  {
    if ($this->second_position === null) {
      $this->second_position = $regionPosition;
    }
  }
  
  public function isInside(Position $position): bool
  {
    $world = $position->getWorld();
    return $this->world->getFolderName() === $world && min($this->first_position->getX(), $this->second_position->getX()) <= $position->getX() && min($this->first_position->getY(), $this->second_position->getY()) <= $position->getY() && min($this->first_position->getZ(), $this->second_position->getZ()) <= $position->getZ() && max($this->first_position->getX(), $this->second_position->getX()) >= $position->getX() && max($this->first_position->getY(), $this->second_position->getY()) >= $position->getY() && max($this->first_position->getZ(), $this->second_position->getZ()) >= $position->getZ();
  }
  
  public function jsonSerialize(): array
  {
    return [
      "name" => $this->name,
      "custom_name" => $this->custom_name,
      "pvp_rule" => $this->pvp_rule,
      "block_rule" => $this->block_rule,
      "hunger_rule" => $this->hunger_rule,
      "world" => $this->world->getFolderName(),
      "first_position" => $this->first_position->__toString(),
      "second_position" => $this->second_position->__toString()
    ];
  }
  
}