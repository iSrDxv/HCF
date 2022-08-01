<?php

namespace isrdxv\hcf\provider;

/**
 * Dependiendo de la extension que eligas en config.yml, esto cambiará a la extensión dada
 */
interface Provider
{
  
  /**
   * Agrega una clave y un dato al archivo solicitado
   * @param strint|int $key 
   * 
   * @example
   * set("crates/coomon.json", "name", "Coomon")
   * Nose por que acepto int, sera para adelantarme a un error futuro?
   * set("crates/coomon.json", 0, ["id" => "245:0"])
   */
  public function set(string $archive, string|int $key, mixed $data): bool;
  
  /**
   * Agrega los elementos con el archivo dado
   * @param array<mixed> $values
   * 
   * @example
   * setAll("example/archive.json", ["string" => "a", 0 => "cero", "bool" => true]);
   */
  public function setAll(string $archive, array $values): bool;
  
  /**
   * Obten solo un dato de la clave solicitada dentro del archivo solicitado
   * 
   * @return mixed
   * 
   * @example
   * get("data/srclauyt.json", "money")
   * Nose por que acepto int, sera para adelantarme a un error futuro?
   * get("data/srclauyt.json", 0)
   */
  public function get(string $archive, string|int $key): mixed;
  
  /**
   * Obtiene todos los datos de un archivo
   * 
   * @return array<mixed>
   * 
   * @example
   * getAll("data/srclauyt.json")
   */
  public function getAll(string $archive): array;
  
  /**
   * Verifica si la clave dada es existe en el archivo
   * @return bool
   * 
   * @example
   * exists("data/srclauyt.json", "name")
   */
  public function exists(string $archive, string $key): bool;
  
}