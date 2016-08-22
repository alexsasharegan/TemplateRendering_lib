<?php

function TemplateRendering_Autoloader($classname) {
  $filename = __DIR__.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.$classname.'.class'.'.php';
  if (is_readable($filename)) {
    require_once $filename;
  }
}

function Model_Autoloader($classname) {
  $filename = __DIR__.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR.$classname.'.class'.'.php';
  if (is_readable($filename)) {
    require_once $filename;
  }
}

spl_autoload_register('TemplateRendering_Autoloader', true);
spl_autoload_register('Model_Autoloader', true);
