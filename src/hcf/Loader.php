<?php

/**
*  __  __  ____     ____           ____     _____   ____    ____      
* /\ \/\ \/\  _`\  /\  _`\        /\  _`\  /\  __`\/\  _`\ /\  _`\    
* \ \ \_\ \ \ \/\_\\ \ \L\_\      \ \ \/\_\\ \ \/\ \ \ \L\ \ \ \L\_\  
*  \ \  _  \ \ \/_/_\ \  _\/_______\ \ \/_/_\ \ \ \ \ \ ,  /\ \  _\L  
*   \ \ \ \ \ \ \L\ \\ \ \//\______\\ \ \L\ \\ \ \_\ \ \ \\ \\ \ \L\ \
*    \ \_\ \_\ \____/ \ \_\\/______/ \ \____/ \ \_____\ \_\ \_\ \____/
*     \/_/\/_/\/___/   \/_/           \/___/   \/_____/\/_/\/ /\/___/ 
*
**/

namespace hcf;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

use pocketmine\entity\EntityDataHelper;
use pocketmine\entity\EntityFactory;

use libs\invmenu\InvMenuHandler;
 
use hcf\EventListener;
 
use hcf\provider\{
  MySQLProvider,
  SQLite3Provider,
  YAMLProvider
};

use hcf\Utils\Utils;

use hcf\discord\Logger;

class Loader extends PluginBase {
   
   public const PLUGIN_VERSION = "1.5.0";
   
   public static Loader $instance;
   
   private static Utils $utils;
   
   public Logger $discord;
   
   public function onLoad(): void 
   {
     self::$instance = $this;
     if (self::PLUGIN_VERSION !== $this->getDescription()->getVersion()) {
      $this->getLogger()->error("Please don't change the `plugin.yml` version, that helps us investigate plugin errors, thanks");
      $this->getLogger()->warning("Any changes you make to the plugin version will not be supported by us.");
     $this->getServer()->getPluginManager()->disablePugin($this);
     }
   }
   
   public function onEnable(): void
   {
     if (!InvMenuHandler::isRegistered()) {
      InvMenuHandler::register($this);
     }
     $this->saveDefaultConfig();
     $this->getServer()->getNetwork()->setName(str_replace("&", "§", $this->getConfig()->get("server-name")) . "§r | " . $this->getConfig()->get("server-color") . $this->getConfig()->get("server-description"));
     /*
     MySQLProvider::connect();
     */
     (new SQLite3Provider())->init();
     YAMLProvider::init();
     $this->discord = new Logger($this->getConfig()->get("webhook-url")/*, $this->getConfig()->get("webhook-check")*/);
     (new EventListener())->init();
     $this->getLogger()->info("=========================================="); 
     $this->getLogger()->notice("
 **      **   ******  ********         ******    *******   *******   ********
/**     /**  **////**/**/////         **////**  **/////** /**////** /**///// 
/**     /** **    // /**             **    //  **     //**/**   /** /**      
/**********/**       /*******  *****/**       /**      /**/*******  /******* 
/**//////**/**       /**////  ///// /**       /**      /**/**///**  /**////  
/**     /**//**    **/**            //**    **//**     ** /**  //** /**      
/**     /** //****** /**             //******  //*******  /**   //**/********
//      //   //////  //               //////    ///////   //     // //////// 
");
     $this->getLogger()->notice("Plugin enabled!!");
     $author = implode(",", $this->getDescription()->getAuthors());
     $this->getLogger()->notice("Authors: §b{$author}");
     $this->getLogger()->info("==========================================");
    
   /* $entityFactory = EntityFactory::getInstance();
		$entityFactory->register(FakeVillager::class, function(World $world, CompoundTag $nbt) : LogoutVillager {
			return new LogoutVillager(EntityDataHelper::parseLocation($nbt, $world), $nbt);
		}, ["FakeVillager"]);*/
   }
   
   public static function getInstance(): Loader
   {
     return self::$instance;
   }
   
   public static function getDiscord(): Logger
   {
     return $this->discord;
   }
   
   public static function getUtils() : Utils {
        return self::$utils;
    }
 
}
