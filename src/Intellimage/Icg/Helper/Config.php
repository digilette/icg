<?php
namespace Intellimage\Icg\Helper;

class Config
{
    private static $_config = null;
    
    private function __construct()
    {
        
    }
    
    public static function getInstance()
    {
        if (!isset(self::$_config)) {
            self::$_config = new self();
        }
        return self::$_config;
    }
    
    public function getBaseDir($path = null)
    {
        return dirname(dirname(dirname(dirname(dirname(__FILE__))))) . (isset($path) ? '/' . $path : '/');
    }
}
