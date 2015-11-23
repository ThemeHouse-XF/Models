<?php

abstract class ThemeHouse_Models_MethodTemplate_Abstract extends ThemeHouse_Reflection_MethodTemplate_Abstract
{
    
    protected static $_reflectionClass = null;
    
    public static function getTable(XenForo_Controller $controller)
    {
        $class = self::getClass($controller);
        
        if (!self::$_reflectionClass) {
            self::$_reflectionClass = new ThemeHouse_Reflection_Class($class);
        }
        
        $name = self::getName($controller);
        
        $method = 'get' . $name . 'ById';
        
        if (self::$_reflectionClass->hasMethod($method)) {
            /* @var $reflectionMethod ThemeHouse_Models_Reflection_Method_Model_GetById */
            $reflectionMethod = self::$_reflectionClass->getMethod($method, 'ThemeHouse_Models_Reflection_Method_Model_GetById');
            
            return $reflectionMethod->getTable();
        }
        
        return false;
    }
    
    public static function getPrimaryKeyId(XenForo_Controller $controller)
    {
        $class = self::getClass($controller);
        
        if (!self::$_reflectionClass) {
            self::$_reflectionClass = new ThemeHouse_Reflection_Class($class);
        }
        
        $name = self::getName($controller);
        
        $method = 'get' . $name . 'ById';
        
        if (self::$_reflectionClass->hasMethod($method)) {
            /* @var $reflectionMethod ThemeHouse_Models_Reflection_Method_Model_GetById */
            $reflectionMethod = self::$_reflectionClass->getMethod($method, 'ThemeHouse_Models_Reflection_Method_Model_GetById');
            
            return $reflectionMethod->getPrimaryKeyId();
        }
        
        return false;
    }
}