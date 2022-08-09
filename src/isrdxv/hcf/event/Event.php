<?php

namespace isrdxv\hcf\event;

class Event
{
  
  public function __construct(string $name, int $time);
  
  //default false
  public function isEnabled(): bool;
  
  public function getName(): string;
  
  public function getTime(): int;
  
  public function getRemainingTime(): int;
  
  
}
