<?php

class ThemeHouse_Models_MethodTemplate_Prepare extends ThemeHouse_Models_MethodTemplate_Abstract
{

    public static function build(XenForo_Controller $controller)
    {
        $body = 'return array();';
        
        $name = self::getName($controller);
        
        return self::createMethod($controller, 'prepare' . $name, $body);
    }
}