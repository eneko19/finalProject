<?php
class TemplateEngine{
 private static $templatesPath;
 private $values = [];
 private $Template;
 
 public function __construct($template) {
  $this->Template = $template;
  return $this;
 }
 
 public static function getTemplatesPath(){
  return self::$templatesPath;
 }
 
 public static function setTemplatesPath($path){
  self::$templatesPath = $path;
 }
 
   public function assign($variable , $value){
        $this->values[$variable] = $value;
        return $this;
    }

 public function pushValues(array $values){
        $this->values = array_merge($this->values, $values);
        return $this;
    }

 public function getValues(){
  return $this->values;
 }

 public function render(){
  $values =  $this->getValues();
  ob_start();
  ob_clean();
  
  $this->templateExists(self::getTemplatesPath().$this->Template."_view.phtml");

  include (self::getTemplatesPath().$this->Template."_view.phtml");

  return ob_get_clean();
 }

 private function templateExists($path){
  if(!file_exists($path)){
   self::Debug("Couln't find template $templateName.",'Error',1);
   exit;
  }
  return true;
 }

}