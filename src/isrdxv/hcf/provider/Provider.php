<?php

namespace isrdxv\hcf\provider;

/**
 * Depending on the extension you choose in config.yml, this will change to the given extension
 */
interface Provider
{
  
  public function __construct(HCFLoader $loader);
  
  /**
   * Add a key and data to the requested file
   * @param strint|int $key 
   * 
   * @example
   * set("crates/coomon.json", "name", "Coomon")
   * I don't know why I accept int, would it be to anticipate a future error?
   * set("crates/coomon.json", 0, ["id" => "245:0"])
   */
  public function set(string $archive, string|int $key, mixed $value): void;
  
  /**
   * Add the elements with the given file
   * @param array<mixed> $values
   * 
   * @example
   * setAll("example/archive.json", ["string" => "a", 0 => "cero", "bool" => true]);
   */
  public function setAll(string $archive, array $values): void;
  
  /**
   * Get only a data of the requested key inside the requested file
   * 
   * @return mixed
   * 
   * @example
   * get("data/srclauyt.json", "money")
   * I don't know why I accept int, would it be to anticipate a future error?
   * get("data/srclauyt.json", 0)
   */
  public function get(string $archive, string|int $key): mixed;
  
  /**
   * Get all data from a file
   * 
   * @return array<mixed>
   * 
   * @example
   * getAll("data/srclauyt.json")
   */
  public function getAll(string $archive): array;
  
  /**
   * Check if the given key is exists in the file
   * @return bool
   * 
   * @example
   * exists("data/srclauyt.json", "name")
   */
  public function exists(string $archive, string $key): bool;
  
}
