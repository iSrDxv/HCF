<?php

namespace isrdxv\hcf\provider;

use PDO;

use isrdxv\hcf\provider\ProviderDB;

class MySQLProvider implements ProviderDB
{
  private PDO $pdo;
  
  public function __construct(PDO $pdo)
  {
    $this->pdo = $pdo;
  }
  
  public function set(PDO $pdo): bool
  {
    if (isset($this->pdo)) {
      $this->pdo = $pdo;
      return true;
    }
    return false;
  }
  
  public function get(): PDO
  {
    return $this->pdo;
  }
  
}
