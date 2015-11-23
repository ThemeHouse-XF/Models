<?php

class ThemeHouse_Models_Listener_LoadClass extends ThemeHouse_Listener_LoadClass
{

    protected function _getExtendedClasses()
    {
        return array(
            'ThemeHouse_Models' => array(
                'route_prefix' => array(
                    'XenForo_Route_PrefixAdmin_AddOns'
                ), 
            ), 
        );
    }

    public static function loadClassRoutePrefix($class, array &$extend)
    {
        $extend = self::createAndRun('ThemeHouse_Models_Listener_LoadClass', $class, $extend, 'route_prefix');
    }
}