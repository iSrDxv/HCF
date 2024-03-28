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

use isrdxv\hcf\HCF;
use isrdxv\hcf\manager\{
  TaskManager,
  RegionManager,
  CrateManager
};
use isrdxv\hcf\task\MOTDTask;

use muqsit\invmenu\InvMenuHandler;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\{
    Filesystem,
    TextFormat,
  SingletonTrait
};

use exodus\translation\Translation;
use isrdxv\hcf\config\ConfigData;

/**
 * TODO: Find a better way to use database
 */
class HCFLoader extends PluginBase
{
  use SingletonTrait;
  
  private Translation $translation;

  private ConfigData $configData;

  public function onLoad(): void
  {
    if ($this->getDescription()->getVersion() !== HCF::VERSION()) {
        $this->getServer()->getPluginManager()->disablePlugin($this);
    }
    if (HCF::IS_IN_DEVELOPMENT) {
      $prefix = str_replace("%type%", "DEVELOPMENT", HCF::PREFIX);
      $this->getLogger()->warning(TextFormat::RED . $prefix . " We recommend you not to use this version, since it is under development");
      $this->getLogger()->warning($prefix . " These types of versions are very prone to fatal errors.");
    }
    self::setInstance($this);
    $this->saveDefaultConfig();
    if (!is_dir($this->getDataFolder() . "languages" . DIRECTORY_SEPARATOR)) {
      @mkdir($this->getDataFolder() . "languages" . DIRECTORY_SEPARATOR);
    }
    if (!is_dir($this->getDataFolder() . "regions" . DIRECTORY_SEPARATOR)) {
      @mkdir($this->getDataFolder() . "regions" . DIRECTORY_SEPARATOR);
    }
    foreach(["languages" . DIRECTORY_SEPARATOR . "en_US.json", "languages" . DIRECTORY_SEPARATOR . "es_ES.json"] as $language) {
      $this->saveResource($language);
    }
    $this->translation = new Translation($this);

    $this->configData = new ConfigData($this->getConfig()->getAll());
    var_dump($this->getConfig()->getAll(true));

    //$this->getServer()->getConfigGroup()->setConfigString("motd", $this->getConfig()->get("server-name"));
    //$this->getServer()->getConfigGroup()->setConfigInt("max-players", $this->getConfig()->get("server-slots"));
    //$this->getServer()->getConfigGroup()->save();
  }
  
  public function onEnable(): void
  {
    if (!InvMenuHandler::isRegistered()) {
      InvMenuHandler::register($this);
    }
    
    //manager
    new TaskManager($this);
    RegionManager::getInstance()->init($this);
    CrateManager::getInstance()->init($this);
    
    //task
    $this->getScheduler()->scheduleRepeatingTask(new MOTDTask($this), 40);
    
    //other
    //$this->registerCommands();
    $this->registerListeners();
  }
  
  public function registerListeners(): void
  {
    $this->registerListener(new HCFListener($this));
    //$this->registerListener(new RegionListener());
  }
  
  private function registerListener(Listener $listener): void
  {
    $this->getServer()->getPluginManager()->registerEvents($listener, $this);
  }

  function getTranslation(): Translation
  {
    return $this->translation;
  }
  
  function getConfigData(): ConfigData
  {
    return $this->configData;
  }

  static function getRegionManager(): RegionManager
  {
    return RegionManager::getInstance();
  }
  
  static function getCrateManager(): CrateManager
  {
    return CrateManager::getInstance();
  }
  
}