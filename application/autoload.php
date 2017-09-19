<?php
spl_autoload_register(function($class){
    $path = "application/";
    $folder = ['classes/', 'core/', 'controllers/', 'models/', 'view/'];
   for($i = 0; $i < count($folder); $i++){
       $path_folder = strtolower($path.$folder[$i].$class.'.php');
       if(file_exists($path_folder)) {
           require_once $path_folder;
       }
   }
});