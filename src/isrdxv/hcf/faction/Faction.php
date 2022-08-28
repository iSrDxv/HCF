<?php

namespace isrdxv\hcf\faction;

interface Faction
{
  /**
   * @param String $name = DEVILS
   * @param Array $members = SrClauYT, SrClauDev8498
   * @param Int $balance = 1000
   * @param Float $dtr = 5.0
   * @param Position $position = your f home 
   */
  public function __construct(string $name, array $members = [], int $balance, float $dtr, ?Position $position);
  
}