<?php

namespace isrdxv\hcf\provider;

/**
 * Dependiendo de la base de datos que selecciones, cambiara su funcionamiento
 */
interface ProviderDB
{
  public function __construct(PDO $pdo);
  
  /**
   * Esto se utiliza, cuando quieres cambiar de base de datos
   */
  public function set(PDO $pdo): bool;
  
  /**
   * Obtiene la base de datos eligida para utilizarlo
   */
  public function get(): PDO;
  
  //pensare si agregar una funcion como la de `exists()` del provder de datos
  // haci optimizo el proceso.
}