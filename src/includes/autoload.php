<?php
/* pour réaliser un autoload, il faut créer un mapping des classes et de leur namespace */
/*
On a déplacé le mapping de l'autoload dans l'interface Config_interface
const ALIASES = [
    'App'=>'Classes',
    'App\\Banque'=>'Classes\\Banque',
    'Utils' => 'Utils',
    'JDR' => 'Classes\\Aventure',
    'App\\Utrain' => 'CLasses\\Utrain'
];
*/

require_once './src/Utils/Config_interface.php';
use Utils\Config_interface;

spl_autoload_register(function($use){

    $namespaceparts = explode('\\', $use);
    $namespace = '';
    for($i=0; $i < count($namespaceparts) - 1; $i++){
        if($i === 0){
            $namespace .= $namespace.$namespaceparts[$i];
        }else{
            $namespace = $namespace.'\\'.$namespaceparts[$i];
        }
    }
    
    $classname = $namespaceparts[count($namespaceparts)-1];
    $pathalias = '';
    if(array_key_exists($namespace, Config_interface::AUTOLOAD_ALIASES)){
        $pathalias = Config_interface::AUTOLOAD_ALIASES[$namespace];
    }

    $paths = [
        join(DIRECTORY_SEPARATOR, [__DIR__, $pathalias]),
        join(DIRECTORY_SEPARATOR, [dirname(__DIR__), $pathalias]),
        join(DIRECTORY_SEPARATOR, [__DIR__, '..',$pathalias])
    ];

    foreach($paths as $path){
        $file = join(DIRECTORY_SEPARATOR, [$path, $classname.'.php']);
        if(file_exists($file)){
            require_once $file;
            return true;
        }
    }
    return false;
});