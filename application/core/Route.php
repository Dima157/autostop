<?php
class Route{
    static function Run(){
        $controller_name = 'Controller_Index';
        $controller_method = 'index';
        $url = $_SERVER['REQUEST_URI'];
        $param = explode('/', $url);
            if ($param[1] != '') {
                $controller_name = 'Controller_' . ucfirst($param[1]);
            }
            if(class_exists($controller_name)) {
                $controller = new $controller_name;
            }else{
                require '../view/view_error.php';
            }

            if (count($param) >= 3) {
                $controller_method = $param[2];
            }
            $all_param = array_slice($param, 3);
            if (count($param) > 3) {
                $controller->$controller_method($all_param);
            } else {
                $controller->$controller_method();
            }
        }


}