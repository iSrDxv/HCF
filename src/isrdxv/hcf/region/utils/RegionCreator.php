<?php

namespace isrdxv\hcf\region\utils;

use isrdxv\hcf\region\utils\RegionData;

class RegionCreator
{
  private string $username;
  
  private string $region_name;
  
  private ?RegionData $regionData;
  
  private int $countSpawn = 1;
  
  public function __construct(string $username, string $region_name, ?RegionData $regionData = null)
  {
    $this->username = $username;
    $this->region_name = $region_name;
    $this->regionData = $regionData;
  }
  
  public function getUsername(): string
  {
    return $this->username;
  }
  
  public function getRegionName(): string
  {
    return $this->region_name;
  }
  
  public function getRegionData(): ?RegionData
  {
    return $this->regionData;
  }
  
  public function verifyCreator(string $username): bool
  {
    return $this->getUsername() === $username;
  }
  
  public function setCountSpawn(int $count): void
  {
    $this->countSpawn = $count;
  }
  
  public function getCountSpawn(): int
  {
    return $this->countSpawn;
  }
  
}
