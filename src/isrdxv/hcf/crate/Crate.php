<?php

namespace isrdxv\hcf\crate;

class Crate
{
  private string $name;
  
  private CrateChest $block;
  
  public function __construct(string $name)
  {
    if (empty($name)) {
      //code
    }
    $this->name = $name;
    $this->block = new CrateChest($blockId, $this);
  }
  
  public function getName(): string
  {
    return $this->name;
  }
  
  public function getBlock(): CrateChest
  {
    return $this->block;
  }
  
}