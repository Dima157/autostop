<?php
class View{
    function generate($template = null, $view_file, $param = null){
        if($param != null && is_array($param)){
            extract($param);
        }
        if($template != null) {
            include "application/view/$template";
        }else{
            include "application/view//$view_file";
        }
    }
}