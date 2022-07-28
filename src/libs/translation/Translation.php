<?php

namespace libs\translation;

use libs\translation\TranslationException;

use pocketmine\plugin\PluginBase;

class Translation
{
  public const MINECRAFT_LANGUAGES = [
    "af_ZA", #Namibia, South Africa
    "ar_SA", #Arab League (Middle East and North Africa)
    "ast_ES", #Asturias (Spanish Autonomous Community)
    "az_AZ", #Azerbaijan, Dagestan, Azerbaijani Iran
    "ba_RU", #Bashkortostan (Russia)
    "bar", #Bavaria
    "be_BY", #Belarus
    "bg_BG", #Bulgaria
    "br_FR", #France
    "brb", #Netherlands
    "bs_BA", #Bosnia and Herzegovina
    "ca_es", #Spain (Catalonia) & Andorra
    "cs_CZ", #Czech Republic
    "cy_GB", #Wales
    "da_DK", #Denmark, Faroe Islands
    "de_AT", #Austria
    "ge_CH", #Switzerland
    "de_DE", #Germany, Austria, Switzerland, Liechtenstein, Luxembourg, Belgium
    "el_GR", #Greece, Cyprus
    "eng_AU", #Australia
    "en_CA", #Canada
    "en_GB", #Great Britain, India, Singapore, Ireland
    "en_NZ", #New Zealand
    "en_PT", #The Seven Seas
    "en_UD", #None
    "enp", #None
    "enws", #None
    "en_US", #United States
    "eo_UY", #Constructed language (international)
    "es_AR", #Argentina
    "es_CL", #Chile
    "es_EC", #Ecuador
    "es_ES", #Spain
    "es_MX" #Mexico
  ];
  
  /** @var PluginBase **/
  private $plugin;
  
  /** @var String **/
  private $defaultLanguage;
  
  public function __construct(PluginBase $plugin)
  {
    $this->plugin = $plugin;
  }
  
  public function getPlugin(): PluginBase
  {
    return $this->plugin;
  }
  
  public function setDefaultLanguage(string $defaultLanguage): void
  {
    if ($this->existsLanguage($defaultLanguage) || empty($defaultLanguage)) {
      throw new TranslationException("[" . $this->plugin->getName() . ": TranslationAPI] the default language does not exist in the game languages or is empty");
    }
    $this->defaultLanguage = $defaultLanguage;
  }
  
  public function getDefaultLanguage(): string
  {
    return $this->defaultLanguage;
  }
  
  public function existsLanguage(string $language): bool
  {
    return in_array($language, self::MINECRAFT_LANGUAGES, true);
  }
  
  public function send(string $language, string $message, ?array $parameters = null): string
  {
    if (empty($message)) {
      throw new TranslationException("[" . $this->plugin->getName() . ": TranslationAPI] the message cannot be empty");
    }
    if (!$this->existsLanguage($language)) {
      throw new TranslationException("[" . $this->plugin->getName() . ": TranslationAPI] the language you have written does not exist in the language of the game");
    }
    $language = (isset(self::MINECRAFT_LANGUAGES[$language])) ? self::MINECRAFT_LANGUAGES[$language] : $this->defaultLanguage;
    if (!is_file($this->plugin->getDataFolder() . "languages" . DIRECTORY_SEPARATOR . $language . ".ini")) {
      throw new TranslationException("[" . $this->plugin->getName() . ": TranslationAPI] sorry, there is no file with that language, this message is for you to add the file of this language");
    }
    $messages = parse_ini_file($this->plugin->getDataFolder() . "languages" . DIRECTORY_SEPARATOR . $language . ".ini");
    $message = $messages[$message];
    if (empty($message)) {
      throw new TranslationException("[" . $this->plugin->getName() . ": TranslationAPI] the message i add does not exist in the language folders");
    }
    return is_array($parameters) ? str_replace(array_merge([], array_keys($parameters)), array_merge([], array_values($parameters)), $message) : $message;
  }
  
}
