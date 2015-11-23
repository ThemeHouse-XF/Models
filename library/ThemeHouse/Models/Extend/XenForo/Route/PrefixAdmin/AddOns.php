<?php
if (false) {

    class XFCP_ThemeHouse_Models_Extend_XenForo_Route_PrefixAdmin_AddOns extends XenForo_Route_PrefixAdmin_AddOns
    {
    }
}

class ThemeHouse_Models_Extend_XenForo_Route_PrefixAdmin_AddOns extends XFCP_ThemeHouse_Models_Extend_XenForo_Route_PrefixAdmin_AddOns
{

    /**
     * Match a specific route for an already matched prefix.
     *
     * @see XenForo_Route_Interface::match()
     */
    public function match($routePath, Zend_Controller_Request_Http $request, XenForo_Router $router)
    {
        $xenOptions = XenForo_Application::get('options');

        if ($xenOptions->th_models_enableAddOnChooser) {
            $action = $router->resolveActionWithStringParam($routePath, $request, 'addon_id');

            if ($request->getParam('addon_id') == 'models') {
                $action = 'models' . $action;
                $request->setParam('addon_id', '');
            }

            if (strlen($action) >= strlen('models') && substr($action, 0, strlen('models')) == 'models') {
                return $router->getRouteMatch('ThemeHouse_Models_ControllerAdmin_Model', substr($action, strlen('models')), 'models');
            }
        }

        return parent::match($routePath, $request, $router);
    }
}