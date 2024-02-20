<?php

namespace isrdxv\hcf\faction;

use pocketmine\world\Position;

interface Faction
{
  /**
   * @param string $name = DEVILS
   * @param array $members = SrClauYT, SrClauDev8498
   * @param int $balance = 1000
   * @param float $dtr = 1.0
   * @param position $position = your f home 
   */
  public function __construct(string $name, array $members = [], int $balance, float $dtr, ?Position $position);
  
}