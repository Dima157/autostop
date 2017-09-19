<?php
class Controller_Parse extends Controller{
    function index()
    {
        $model = new Model_Parse();
        $name = $_POST['city'];
        $res = $model->getPlace($name);
        for($i = 0; $i < count($res); $i++){
            echo $res[$i];
        }
    }
}