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

use isrdxv\hcf\HCF;
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

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\{
  TextFormat,
  SingletonTrait
};

class HCFLoader extends PluginBase
{
  use SingletonTrait;
  
  private Provider $provider;
  
  private ProviderDB $providerDB;
  
  private RegionManager $regionManager;

  private CrateManager $crateManager;
  
  public function onLoad(): void
  {
    if ($this->getDescription()->getVersion() !== HCF::VERSION()) {
        $this->getServer()->getPluginManager()->disablePlugin($this);
    }
    if (HCF::IS_IN_DEVELOPMENT) {
      $prefix = str_replace("%type%", "DEVELOPMENT", HCF::PREFIX);
      $this->getLogger()->warning(TextFormat::RED . $prefix . " We recommend you not to use this version, since it is under development");
      $this->getLogger()->warning($prefix . "These types of versions are very prone to fatal errors.");
    }
    self::setInstance($this);
    $this->saveDefaultConfig();
    if (!is_dir($this->getDataFolder() . "languages")) {
      @mkdir($this->getDataFolder() . "languages");
    }
    if (!is_dir($this->getDataFolder() . "regions")) {
      @mkdir($this->getDataFolder() . "regions");
    }
    foreach(glob($this->getDataFolder() . "languages/*.ini") as $language) {
      $this->saveResource($language, false);
    }
    switch($this->getConfig()->get("provider")["database"]["name"]){
      case "sqlite3":
        $sqlite = $this->getConfig()->get("provider")["database"]["sqlite3"]["file-name"];
        $this->providerDB = new SQLite3Provider(new PDO("sqlite:" . $this->getDataFolder() . DIRECTORY_SEPARATOR . $sqlite));
      break;
      case "mysql":
        if (file_exists($this->getDataFolder() . $this->getConfig()->get("provider")["database"]["sqlite3"]["file-name"])) {
          //unlink($this->getDataFolder() . $this->getConfig()->get("provider")["database"]["sqlite3"]["file-name"]);
        }
        $sql = $this->getConfig()->get("provider")["database"]["mysql"];
        $this->providerDB = new MySQLProvider(new PDO("mysql:host={$sql["address"]};port={$sql["port"]};dbname={$sql["dbname"]};charset=UTF8", $sql["username"], $sql["pass"]));
      break;
      default:
        $this->getServer()->getPluginManager()->disablePlugin($this);
      break;
    }
    switch($this->getConfig()->get("provider")["data"]["name"]){
      case "yaml":
        $this->provider = new YamlProvider($this);
      break;
      case "json":
        $this->provider = new JsonProvider($this);
      break;
      default:
        $this->getServer()->getPluginManager()->disablePlugin($this);
      break;
    }
    $this->getServer()->getConfigGroup()->setConfigString("motd", $this->getConfig()->get("server-name"));
    $this->getServer()->getConfigGroup()->setConfigInt("max-players", $this->getConfig()->get("server-slots"));
  }
  
  public function onEnable(): void
  {
    if (!InvMenuHandler::isRegistered()) {
      InvMenuHandler::register($this);
    }
    
    //manager
    new TaskManager($this);
    $this->regionManager = new RegionManager($this);
    $this->crateManager = new CrateManager($this);
    
    //task
    $this->getScheduler()->scheduleRepeatingTask(new MOTDTask($this), 40);
    
    //other
    //$this->registerCommands();
    $this->registerListeners();
  }
  
  public function registerListeners(): void
  {
    $this->registerListener(new HCFListener($this));
    $this->registerListener(new RegionListener());
  }
  
  private function registerListener(Listener $listener): void
  {
    $this->getServer()->getPluginManager()->registerEvents($listener, $this);
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
