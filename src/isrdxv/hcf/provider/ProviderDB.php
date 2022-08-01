<?php

namespace isrdxv\hcf\provider;

/**
 * Depending on the database you select, its operation will change
 */
interface ProviderDB
{
  public function __construct(PDO $pdo);
  
  /**
   * This is used, when you want to change database
   */
  public function set(PDO $pdo): bool;
  
  /**
   * Obtiene la base de datos eligida para utilizarlo
   */
  public function get(): PDO;
  
  //I'll think about adding a function like `exists()` from the data provider
  //I have optimized the process.
}
