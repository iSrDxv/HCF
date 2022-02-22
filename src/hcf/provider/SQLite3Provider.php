<?php

namespace hcf\provider;

use SQLite3;

use pocketmine\utils\TextFormat as Text;

use hcf\Loader;

class SQLite3Provider 
{
  
  protected SQLite3 $connection;
  
  public function init(): void
  {
  $sql = new SQLite3(Loader::getInstance()->getDataFolder() . "factions.db");
  $sql->exec("CREATE TABLE IF NOT EXISTS claims(factionName TEXT PRIMARY KEY, x_1 INT, y_1 INT, z_1 INT, x_2 INT, y_2 INT, z_2 INT, level TEXT);");
  $sql->exec("CREATE TABLE IF NOT EXISTS homes(factionName TEXT PRIMARY KEY, x INT, y INT, z INT, level TEXT);");
  $sql->exec("CREATE TABLE IF NOT EXISTS balances(factionName TEXT PRIMARY KEY, money INT);");
  $sql->exec("CREATE TABLE IF NOT EXISTS strength(factionName TEXT PRIMARY KEY, dtr INT);");
  $sql->exec("CREATE TABLE IF NOT EXISTS tops(factionName TEXT PRIMARY KEY, points INT);");
  $sql->exec("CREATE TABLE IF NOT EXISTS members(factionName TEXT PRIMARY KEY, members TEXT);");
  $sql->exec("CREATE TABLE IF NOT EXISTS players(username TEXT PRIMARY KEY, factionName TEXT, factionRank TEXT);");
  $this->connection = $sql;
  Loader::getInstance()->getLogger()->notice(Text::GREEN . "SQLite3Provider ⋙ uploaded successfully");
  }
  
  public function closeConnection(): void
  {
  $this->connection->close();
  }
  
  public function getDatabase()
  {
  return $this->connection ?? null;
  }

}