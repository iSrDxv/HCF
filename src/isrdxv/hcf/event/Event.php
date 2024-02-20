<?php

namespace isrdxv\hcf\event;

interface Event
{
  
  function __construct(string $name, int $time);
  
  function setEnabled(bool $value = true): void;
  
  //default false
  function isEnabled(): bool;

  function getName(): string;
  
  function getTime(): int;
  
  function getRemainingTime(): int;
  
}