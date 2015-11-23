<?php

class ThemeHouse_Models_Listener_FileHealthCheck
{

    public static function fileHealthCheck(XenForo_ControllerAdmin_Abstract $controller, array &$hashes)
    {
        $hashes = array_merge($hashes,
            array(
                'library/ThemeHouse/Models/ControllerAdmin/Model.php' => '9437531d3b78dee0e42538f4d9dee350',
                'library/ThemeHouse/Models/Extend/XenForo/Route/PrefixAdmin/AddOns.php' => '57786be347e5ae2ba7d8a7e3d469e527',
                'library/ThemeHouse/Models/Helper/Model.php' => '6f45903507761cb292daa4bdd0dc56eb',
                'library/ThemeHouse/Models/Install/Controller.php' => '31c57da509d0e5aa99e3dd79a9dc3a01',
                'library/ThemeHouse/Models/Listener/LoadClass.php' => '0a16cdc6ccfd85aead7e3b9bbc22adee',
                'library/ThemeHouse/Models/MethodTemplate/Abstract.php' => '5bce7cef90c044b70de2c5aafa03ebee',
                'library/ThemeHouse/Models/MethodTemplate/GetAll.php' => '0edf2d1bb28422bc7436eece3deeb482',
                'library/ThemeHouse/Models/MethodTemplate/Prepare.php' => '550c9043d1c3339458d41eb4e82a8094',
                'library/ThemeHouse/Models/Model/Test.php' => '1ffec45adab2a5424fc4375894b9a571',
                'library/ThemeHouse/Models/Reflection/Method/Model/GetById.php' => 'db6e4f2b9495da35533c741dbce2035c',
                'library/ThemeHouse/Models/ReflectionHandler/Model.php' => '6bc25bcf0d72fb745a8bdef6d225c364',
                'library/ThemeHouse/Models/Route/PrefixAdmin/Models.php' => '2a9439af49ba86c6eceda9ad7f2ca822',
                'library/ThemeHouse/Install.php' => '18f1441e00e3742460174ab197bec0b7',
                'library/ThemeHouse/Install/20151109.php' => '2e3f16d685652ea2fa82ba11b69204f4',
                'library/ThemeHouse/Deferred.php' => 'ebab3e432fe2f42520de0e36f7f45d88',
                'library/ThemeHouse/Deferred/20150106.php' => 'a311d9aa6f9a0412eeba878417ba7ede',
                'library/ThemeHouse/Listener/ControllerPreDispatch.php' => 'fdebb2d5347398d3974a6f27eb11a3cd',
                'library/ThemeHouse/Listener/ControllerPreDispatch/20150911.php' => 'f2aadc0bd188ad127e363f417b4d23a9',
                'library/ThemeHouse/Listener/InitDependencies.php' => '8f59aaa8ffe56231c4aa47cf2c65f2b0',
                'library/ThemeHouse/Listener/InitDependencies/20150212.php' => 'f04c9dc8fa289895c06c1bcba5d27293',
                'library/ThemeHouse/Listener/LoadClass.php' => '5cad77e1862641ddc2dd693b1aa68a50',
                'library/ThemeHouse/Listener/LoadClass/20150518.php' => 'f4d0d30ba5e5dc51cda07141c39939e3',
            ));
    }
}