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

use isrdxv\hcf\provider\{
  Provider,
  ProviderDB
};

use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;

class HCFLoader extends PluginBase
{
  use SingletonTrait;
  
  private Provider $provider;
  
  private ProviderDB $providerDB;
  
  public ?string $data_extension = null;
  
  public function onLoad(): void
  {
    self::setInstance($this);
    $this->saveDefaultConfig();
    switch($this->getConfig()->get("provider")["database"]["name"]){
      case "sqlite3":
        $this->providerDB;
      break;
      case "mysql":
        $this->providerDB;
      break;
      default:
        $this->getServer()->getPluginManager()->disablePlugin($this);
      break;
    }
  }
  
  public function getProvider(): Provider
  {
    return $this->provider;
  }
  
  public function getProviderDB(): ProviderDB
  {
    return $this->providerDB;
  }
  
}
