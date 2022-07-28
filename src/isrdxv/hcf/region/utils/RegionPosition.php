<?php

namespace hcf\region\utils;

use pocketmine\math\Vector3;

use pocketmine\entity\Location;

class RegionPosition extends Vector3
{
  public float $yaw;
  
  public float $pitch;
  
  public function __construct(float|int $x, float|int $y, float|int $z, float $yaw = 0.0, float $pitch = 0.0)
  {
    $this->yaw = $yaw;
    $this->pitch = $pitch;
    parent::__construct($x, $y, $z);
  }
  
  public function getYaw(): float
  {
    return $this->yaw;
  }
  
  public function getPitch(): float
  {
    return $this->pitch;
  }
  
  public function fromObject(Vector3 $pos, float $yaw = 0.0, float $pitch 0.0): self
  {
    return new self($pos->x, $pos->y, $pos->z, $yaw, $pitch);
  }
  
  public static function fromString(string $value): self
  {
    $pos = explode(":", $value);
    return new self($pos[0], $pos[1], $pos[2], $pos[3], $pos[4]);
  }
  
  public function asRegionPosition(): self
  {
    return new self($this->x, $this->y, $this->z, $this->yaw, $this->pitch);
  }
  
  public function equals(Vector3 $vector): bool
  {
    if ($vector instanceof Location) {
      return $this->yaw === $vector->yaw && $this->pitch === $vector->pitch and parent::equals($vector);
    }
    return parent::equals($vector);
  }
  
  public function __toString(): string
  {
    return $this->x . ":" . $this->y . ":" . $this->z . ":" . $this->yaw . ":" . $this->pitch;
  }
  
}
