<?php

namespace isrdxv\hcf\event;

class Event
{
  
  public function __construct(string $name, bool $enabled = false, int $time);
  
  public function isEnabled(): bool;
  
  public function getName(): string;
  
  public function getTime(): int;
  
  public function getRemainingTime(): int;
  
  
}