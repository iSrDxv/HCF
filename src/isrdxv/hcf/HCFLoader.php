<?php
#  **      **   ******  ********         ******    *******   *******   ********
# /**     /**  **////**/**/////         **////**  **/////** /**////** /**///// 
# /**     /** **    // /**             **    //  **     //**/**   /** /**      
# /**********/**       /*******  *****/**       /**      /**/*******  /******* 
# /**//////**/**       /**////  ///// /**       /**      /**/**///**  /**////  
# /**     /**//**    **/**            //**    **//**     ** /**  //** /**      
# /**     /** //****** /**             //******  //*******  /**   //**/********
# //      //   //////  //               //////    ///////   //     // //////// 
# 
# Copyright (C) 2022 iSrDxv
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.

namespace isrdxv\hcf;

use PDO;

use isrdxv\hcf\provider\{
  Provider,
  ProviderDB,
  MySQLProvider,
  SQLite3Provider,
  JsonProvider,
  YamlProvider
};
use isrdxv\hcf\manager\{
  TaskManager,
  RegionManager,
  CrateManager
};

use muqsit\invmenu\InvMenuHandler;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;

class HCFLoader extends PluginBase
{
  use SingletonTrait;
  
  private Provider $provider;
  
  private ProviderDB $providerDB;
  
  private RegionManager $regionManager;

  private CrateManager $crateManager;
  
  public ?string $data_extension = null;
  
  public function onLoad(): void
  {
    self::setInstance($this);
    $this->saveDefaultConfig();
    if (!is_dir($this->getDataFolder() . "languages")) {
      @mkdir($this->getDataFolder() . "languages");
    }
    if (!is_dir($this->getDataFolder() . "regions")) {
      @mkdir($this->getDataFolder() . "regions");
    }
    foreach([$this->getDataFolder() . "languages/en_CA.ini", $this->getDataFolder() . "languages/en_US.ini", $this->getDataFolder() . "languages/es_ES.ini"] as $language) {
      $this->saveResource($language, false);
    }
    switch($this->getConfig()->get("provider")["database"]["name"]){
      case "sqlite3":
        $sqlite = $this->getConfig()->get("provider")["database"]["sqlite3"]["file-name"];
        $this->providerDB = new SQLite3Provider(new PDO("sqlite3:" . $this->getDataFolder() . $sqlite));
      break;
      case "mysql":
        $sql = $this->getConfig()->get("provider")["database"]["mysql"];
        $this->providerDB = new MySQLProvider(new PDO("mysql:host={$sql["address"]};port={$sql["port"]};dbname={$sql["dbname"]};charset=UTF8", $sql["username"], $sql["pass"]));
      break;
      default:
        $this->getServer()->getPluginManager()->disablePlugin($this);
      break;
    }
    switch($this->getConfig()->get("provider")["data"]["name"]){
      case "yaml":
        $this->data_extension = "yml";
        $this->provider = new YamlProvider();
      break;
      case "json":
        $this->data_extension = "json";
        $this->provider = new JsonProvider();
      break;
      default:
        $this->getServer()->getPluginManager()->disablePlugin($this);
      break;
    }
  }
  
  public function onEnable(): void
  {
    if (!InvMenuHandler::isRegistered()) {
      InvMenuHandler::register($this);
    }
    new TaskManager($this);
    $this->regionManager = new RegionManager($this);
    $this->crateManager = new CrateManager($this);
    $this->getServer()->getPluginManager()->registerEvents(new HCFListener(), $this);
    //$this->getServer()->getPluginManager()->registerEvents(new RegionListener(), $this);
  }
  
  public function getProvider(): Provider
  {
    return $this->provider;
  }
  
  public function getProviderDB(): ProviderDB
  {
    return $this->providerDB;
  }
  
  public function getRegionManager(): RegionManager
  {
    return $this->regionManager;
  }
  
  public function getCrateManager(): CrateManager
  {
    return $this->crateManager;
  }
  
}
