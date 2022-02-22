<?php

namespace hcf\provider;

use pocketmine\utils\{Config,TextFormat as Text};

use hcf\Loader;

class YAMLProvider {

  public static function init(): void 
  {
    if (!is_dir(Loader::getInstance()->getDataFolder())) {
      @mkdir(Loader::getInstance()->getDataFolder());
    }
    if (!is_dir(Loader::getInstance()->getDataFolder() . "backups" . DIRECTORY_SEPARATOR)) {
      @mkdir(Loader::getInstance()->getDataFolder() . "backups" . DIRECTORY_SEPARATOR);
    }
    if (!is_dir(Loader::getInstance()->getDataFolder() . "players" . DIRECTORY_SEPARATOR)) {
      @mkdir(Loader::getInstance()->getDataFolder() . "players" . DIRECTORY_SEPARATOR);
    }
    Loader::getInstance()->saveResource("listcrates.yml");
    Loader::getInstance()->saveResource("listitems.yml");
    Loader::getInstance()->saveResource("messages.yml");
    Loader::getInstance()->getLogger()->notice(Text::GREEN . "YAMLProvider ⋙ uploaded successfully");
  }

}
?>