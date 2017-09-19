<?php
class Controller_Chat extends Controller{
    function index()
    {
        throw new ErrorException('not-implements');
    }

    function add_mess(){
        $message = $_POST['message'];
        $id = $_SESSION['id'];
        $id_group = $_POST['id_group'];
        $model = new Model_Chat();
        $model->add($message, $id, $id_group);

    }
}