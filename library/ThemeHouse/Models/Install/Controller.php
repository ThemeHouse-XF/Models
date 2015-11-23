<?php

class ThemeHouse_Models_Install_Controller extends ThemeHouse_Install
{

    protected $_resourceManagerUrl = 'https://xenforo.com/community/resources/models.4056/';

    protected function _getPrerequisites()
    {
        return array(
            'ThemeHouse_Reflection' => '1'
        );
    }

    protected function _getContentTypes()
    {
        return array(
            'model' => array(
                'addon_id' => 'ThemeHouse_Models',
                'fields' => array(
                    'reflection_handler_class' => 'ThemeHouse_Models_ReflectionHandler_Model'
                )
            )
        );
    }

    protected function _postInstall()
    {
        $this->_db->query(
            "
            INSERT INTO xf_method_template (title, callback_class, callback_method, content_type) VALUES
                ('prepare', 'ThemeHouse_Models_MethodTemplate_Prepare', 'build', 'model'),
                ('getAll', 'ThemeHouse_Models_MethodTemplate_GetAll', 'build', 'model')
            ON DUPLICATE KEY UPDATE title = VALUES(title)
        ");
    }
}