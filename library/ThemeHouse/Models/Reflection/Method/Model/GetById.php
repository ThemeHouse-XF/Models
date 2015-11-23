<?php

class ThemeHouse_Models_Reflection_Method_Model_GetById extends ThemeHouse_Reflection_Method
{
    
    public function getTable()
    {
        $body = $this->getBody();
        
        preg_match('#FROM ([a-z_]*)\s#Us', $body, $matches);
        
        if (!empty($matches[1])) {
            return $matches[1];
        }
        
        return false;
    }
    
    public function getPrimaryKeyId()
    {
        $body = $this->getBody();
    
        preg_match('#WHERE ([a-z_]*)\s#Us', $body, $matches);
    
        if (!empty($matches[1])) {
            return $matches[1];
        }
    
        return false;
    }
}