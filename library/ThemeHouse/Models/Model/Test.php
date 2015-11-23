<?php

class ThemeHouse_Models_Model_Test extends XenForo_Model
{



    public function getTests()
    {
        $limitOptions = $this->prepareLimitFetchOptions($fetchOptions);
        
        return $this->fetchAllKeyed(
            $this->limitQueryResults('
            SELECT *
            FROM xf_test
        ', $limitOptions['limit'], $limitOptions['offset']),
            'test_id');
    }
}