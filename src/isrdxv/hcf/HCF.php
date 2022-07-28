<?php
#  **      **   ******  ********         ******    *******   *******   ********
# /**     /**  **////**/**/////         **////**  **/////** /**////** /**///// 
# /**     /** **    // /**             **    //  **     //**/**   /** /**      
# /**********/**       /*******  *****/**       /**      /**/*******  /******* 
# /**//////**/**       /**////  ///// /**       /**      /**/**///**  /**////  
# /**     /**//**    **/**            //**    **//**     ** /**  //** /**      
# /**     /** //****** /**             //******  //*******  /**   //**/********
# //      //   //////  //               //////    ///////   //     // //////// 
# Copyright (C) 2022 iSrDxv
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
namespace isrdxv\hcf;

class HCF
{
  public const PREFIX = "§0[§fHCF: %type%§0]";
  
  public const SUCCESS_PREFIX = self::PREFIX . " §a» §7%message%";
  
  public const WARNING_PREFIX = self::PREFIX . " §6» §7%message%";
  
  public const INFO_PREFIX = self::PREFIX . " §f» §7%message%";
  
  public const ERROR_PREFIX = self::PREFIX . " §c» §7%message%";
  
  public const BYPASS_PERMISSION = "hcf.bypass";
  
  public const WEBHOOK_URL = "";
  
  public const KOTH_WEBHOOK = "";
  
  public const SOTW_WEBHOOK = "";
  
  public const EOTW_WEBHOOK = "";
  
}
