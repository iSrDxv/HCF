<?php

namespace libs\cache;

use function is_bool;
use function is_array;
use function is_string;
use function is_numeric;
use function is_float;

class Cache
{
  private mixed $data;
  
  public function __construct(mixed $data)
  {
    if (is_null($data)) {//because? because i want
      $this->data = $data;
    }
    if (is_bool($data)) {
      $this->data = $data;
    }
    if (is_string($data)) {
      $this->data = $data;
    }
    if (is_numeric($data) || is_float($data)) {
      $this->data = $data;
    }
    if (is_array($data)) {
      foreach($data as $key => $value) {
        $this->data[$key] = $value;
      }
    }
  }
  
  public function exists(string $key = null): bool
  {
    return is_bool($this->data) || is_numeric($this->data) || is_float($this->data) || is_string($this->data) ? true : false ?? $key !== null && isset($this->data[$key]) ? true : false;
  }
  
  public function getData(): mixed
  {
    return $this->data;
  }
  
}
