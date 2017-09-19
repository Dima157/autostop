<?php
class Controller_Avatar extends Controller{
    private $model;
    function __construct()
    {
        parent::__construct();
        $this->model = new Model_Avatar();
    }

    function index()
    {
        $obj = $_POST['obj'];
        $obj = json_decode($obj);
        $id_photo = $obj->id;
        $left = $obj->left;
        $top = $obj->top;
        $width = $obj->width;
        $this->model->insertAvatar($id_photo, $left, $top, $width);
    }

    function upload(){

    }
}