<?php

class ThemeHouse_Models_MethodTemplate_GetAll extends ThemeHouse_Models_MethodTemplate_Abstract
{

    public static function build(XenForo_Controller $controller, $class, $prefix, $contentType)
    {
        $signature = 'array $conditions = array(), array $fetchOptions = array()';

        $configValues = array(
            'table' => self::getTable($controller),
            'primary_key_id' => self::getPrimaryKeyId($controller),
            'method' => 'get' . self::getPluralName($controller)
        );

        self::checkConfiguration($controller, $class, $prefix, $contentType, $configValues,
            array(
                'table' => array(
                    'name' => new XenForo_Phrase('th_table_name_reflection'),
                    'required' => true
                ),
                'primary_key_id' => array(
                    'name' => new XenForo_Phrase('th_primary_key_id_reflection'),
                    'required' => true
                ),
                'method' => array(
                    'name' => new XenForo_Phrase('th_method_name_reflection'),
                    'required' => true
                )
            ));

        $bodyArray = array(
            '$limitOptions = $this->prepareLimitFetchOptions($fetchOptions);',
            '',
            'return $this->fetchAllKeyed(',
            "\t" . '$this->limitQueryResults(\'',
            "\t" . 'SELECT *',
            "\t" . 'FROM ' . $configValues['table'],
            '\', $limitOptions[\'limit\'], $limitOptions[\'offset\']),',
            "\t" . '\'' . $configValues['primary_key_id'] . '\');'
        );

        $body = implode(PHP_EOL, $bodyArray);

        return self::createMethod($controller, $configValues['method'], $body, $signature);
    }
}