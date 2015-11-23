<?php

class ThemeHouse_Models_ControllerAdmin_Model extends ThemeHouse_Reflection_ControllerAdmin_Abstract
{

    public function actionIndex()
    {
        $class = $this->_input->filterSingle('class', XenForo_Input::STRING);
        
        if ($class) {
            return $this->responseReroute(__CLASS__, 'view');
        }
        
        $addOns = $this->_getAddOnModel()->getAllAddOns();
        
        $xenOptions = XenForo_Application::get('options');
        
        $addOnSelected = '';
        
        if ($xenOptions->th_models_enableAddOnChooser) {
            $addOnId = $this->_input->filterSingle('addon_id', XenForo_Input::STRING);
            
            if (!empty($GLOBALS['ThemeHouse_Models_Route_PrefixAdmin_Models']) && !$addOnId) {
                $addOnId = XenForo_Helper_Cookie::getCookie('edit_addon_id');
            }
            
            if ($addOnId && !empty($addOns[$addOnId])) {
                XenForo_Helper_Cookie::setCookie('edit_addon_id', $addOnId);
                
                $addOn = $addOns[$addOnId];
                
                $addOnSelected = $addOnId;
                
                $this->canonicalizeRequestUrl(XenForo_Link::buildAdminLink('add-ons/models', $addOn));
            } else {
                $this->canonicalizeRequestUrl(XenForo_Link::buildAdminLink('add-ons/models'));
                
                XenForo_Helper_Cookie::deleteCookie('edit_addon_id');
            }
        }
        
        $addOns['XenForo'] = array(
            'addon_id' => 'XenForo',
            'active' => true,
            'title' => 'XenForo'
        );
        
        $rootPath = XenForo_Autoloader::getInstance()->getRootDir();
        
        $models = array();
        $modelCount = 0;
        $totalModels = 0;
        
        foreach ($addOns as $addOnId => $addOn) {
            $modelPath = $rootPath . DIRECTORY_SEPARATOR . str_replace('_', DIRECTORY_SEPARATOR, $addOnId) .
                 DIRECTORY_SEPARATOR . 'Model';
            
            if (!file_exists($modelPath)) {
                continue;
            }
            
            $directory = new RecursiveDirectoryIterator($modelPath);
            $iterator = new RecursiveIteratorIterator($directory);
            $regex = new RegexIterator($iterator, '/^.+\.php$/i', RecursiveRegexIterator::GET_MATCH);
            
            foreach ($regex as $fileinfo) {
                $classPath = str_replace($rootPath, '', $fileinfo[0]);
                $classPath = pathinfo($classPath, PATHINFO_DIRNAME) . DIRECTORY_SEPARATOR .
                     pathinfo($classPath, PATHINFO_FILENAME);
                $dirs = explode(DIRECTORY_SEPARATOR, $classPath);
                $dirs = array_filter($dirs);
                $className = implode('_', $dirs);
                if (!$xenOptions->th_models_enableAddOnChooser || !$addOnSelected || $addOnId == $addOnSelected) {
                    $models[$addOnId][$className] = array(
                        'class' => $className,
                        'filename' => pathinfo($classPath, PATHINFO_FILENAME)
                    );
                    $modelCount++;
                }
                $totalModels++;
            }
        }
        
        unset($addOns['XenForo']);
        
        $viewParams = array(
            'addOns' => $addOns,
            'addOnSelected' => $addOnSelected,
            
            'models' => $models,
            'modelCount' => $modelCount,
            'totalModels' => $totalModels
        );
        
        return $this->responseView('ThemeHouse_Models_ViewAdmin_Model_List', 'th_model_list_models', $viewParams);
    }

    public function actionView()
    {
        $class = $this->_input->filterSingle('class', XenForo_Input::STRING);
        
        try {
            $model = XenForo_Model::create($class);
        } catch (Exception $e) {
        }
        
        if (empty($model) || !$model instanceof XenForo_Model) {
            return $this->responseNoPermission();
        }
        
        $reflectionClass = new ThemeHouse_Reflection_Class(get_class($model));
        
        $reflectionMethods = $reflectionClass->getMethods();
        
        $methods = array();
        foreach ($reflectionMethods as $reflectionMethod) {
            /* @var $reflectionMethod ReflectionMethod */
            $methodName = $reflectionMethod->getName();
            $declaringClass = $reflectionMethod->getDeclaringClass();
            $methods[$methodName]['declaringClass'] = $declaringClass->getName();
            $methods[$methodName]['isAbstract'] = $reflectionMethod->isAbstract();
            $methods[$methodName]['isConstructor'] = $reflectionMethod->isConstructor();
            $methods[$methodName]['isDeprecated'] = $reflectionMethod->isDeprecated();
            $methods[$methodName]['isDestructor'] = $reflectionMethod->isDestructor();
            $methods[$methodName]['isFinal'] = $reflectionMethod->isFinal();
            $methods[$methodName]['isInternal'] = $reflectionMethod->isInternal();
            $methods[$methodName]['isPrivate'] = $reflectionMethod->isPrivate();
            $methods[$methodName]['isProtected'] = $reflectionMethod->isProtected();
            $methods[$methodName]['isPublic'] = $reflectionMethod->isPublic();
            $methods[$methodName]['isStatic'] = $reflectionMethod->isStatic();
            $methods[$methodName]['isUserDefined'] = $reflectionMethod->isUserDefined();
        }
        
        $model = array(
            'class' => $class
        );
        
        $viewParams = array(
            'model' => $model,
            'methods' => $methods
        );
        
        return $this->responseView('ThemeHouse_Models_ViewAdmin_Model_View', 'th_model_view_models', $viewParams);
    }

    public function actionAdd()
    {
        $addOnSelected = $this->_input->filterSingle('addon_id', XenForo_Input::STRING);
        
        $addOnModel = $this->_getAddOnModel();
        
        $viewParams = array(
            'addOnOptions' => $addOnModel->getAddOnOptionsListIfAvailable(),
            'addOnSelected' => $addOnSelected
        );
        
        return $this->responseView('ThemeHouse_Models_ViewAdmin_Model_Add', 'th_model_add_models', $viewParams);
    }

    public function actionSave()
    {
        $input = $this->_input->filter(
            array(
                'class' => XenForo_Input::STRING,
                'addon_id' => XenForo_Input::STRING
            ));
        
        $phpFile = new ThemeHouse_PhpFile($input['addon_id'] . '_Model_' . $input['class']);
        $phpFile->setExtends('XenForo_Model');
        
        $phpFile->export();
        
        $model = array(
            'class' => $input['addon_id'] . '_Model_' . $input['class']
        );
        
        XenForo_Helper_Cookie::setCookie('edit_addon_id', $input['addon_id']);
        
        return $this->responseRedirect(XenForo_ControllerResponse_Redirect::RESOURCE_CREATED, 
            XenForo_Link::buildAdminLink('models', $model));
    }

    public function actionAddMethod()
    {
        $class = $this->_input->filterSingle('class', XenForo_Input::STRING);
        
        $model = XenForo_Model::create($class);
        
        if (empty($model) || !$model instanceof XenForo_Model) {
            return $this->responseNoPermission();
        }
        
        return $this->_getMethodAddResponse($model, 'models', 'model');
    }

    public function actionEditMethod()
    {
        $className = $this->_input->filterSingle('class', XenForo_Input::STRING);
        
        $class = XenForo_Model::create($className);
        
        if (empty($class) || !$class instanceof XenForo_Model) {
            return $this->responseNoPermission();
        }
        
        return $this->_getMethodEditResponse($class, 'models');
    }

    public function actionDeleteMethod()
    {
        $className = $this->_input->filterSingle('class', XenForo_Input::STRING);
        
        $class = XenForo_Model::create($className);
        
        if (empty($class) || !$class instanceof XenForo_Model) {
            return $this->responseNoPermission();
        }
        
        return $this->_getMethodDeleteResponse($class, 'models');
    }

    protected function _getAddOnIdFromClassName($className)
    {
        return ThemeHouse_Models_Helper_Model::getAddOnIdFromModelClass($className);
    }
}