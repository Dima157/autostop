<?php
class Controller_User extends Controller{
    private $model;
    function __construct()
    {
        parent::__construct();
        if(Model_Auth::check()){
            $this->model = Model_Auth::User();
        }
    }

    function index(){
        throw new Exception('no method');
    }


}