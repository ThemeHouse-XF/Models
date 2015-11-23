<?php

class ThemeHouse_Models_Helper_Model
{

    public static function getAddOnIdFromModelClass($class)
    {
        preg_match('#^([A-z_]*)_Model_[A-z_]*$#', $class, $matches);

        $class = $matches[1];

        preg_match('#^([A-z_]*)_Extend_[A-z_]*$#', $class, $matches);

        if ($matches) {
            $class = $matches[1];
        }

        return $class;
    }

}