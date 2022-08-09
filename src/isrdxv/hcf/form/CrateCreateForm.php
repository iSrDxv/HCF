<?php

namespace isrdxv\hcf\form;

use isrdxv\hcf\session\Session;

use dktapps\pmforms\{
  CustomForm,
  CustomFormResponse,
  element\Input,
  element\Label
};

use pocketmine\player\Player;

class CrateCreateForm extends CustomForm
{
  
  public function __construct(Session $session)
  {
    parent::__construct("Crate UI", [
      new Input("name", "Name for your crate", "Common"),
      new Input("customName", "Custom name foo your crate", "§bCommon"),
      new Input("tags", "Labels or rather text above your crate (Separate them with `,`)", "Right-Click open, Left-Click review"),
      new Input("keyName", "Name of your key", "§6Common Key"),
      new Input("keyLore", "Lore of your key (Separate them with `,`)", "Test, IDK")
      ], function(Player $player, CustomFormResponse $response) use($session): void {
        if (empty($response->getString("name")) || empty($response->getString("customName")) || empty($response->getString("tags")) || empty($response->getString("keyName")) || empty($response->getString("keyLore"))) {
          return;
        }
        $tags = explode(",", $response->getString("tags"));
        $keyLore = explode(",", $response->getString("keyLore"));
        $session->getCache()->set("cache", [
          "name" => $response->getString("name"),
          "customName" => $response->getString("customName"),
          "tags" => $tags,
          "keyName" => $response->getString("keyName"),
          "keyLore" => $keyLore
        ]);
        $player->sendMessage("Crate data ready, now use /crate give <crateName>");
    });
  }
  
}
