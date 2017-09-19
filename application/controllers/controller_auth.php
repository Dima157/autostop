<?php
class Controller_Auth extends Controller{
    private $model;
    function __construct()
    {
        parent::__construct();
        $this->model = new Model_Auth();
    }

    function index()
    {
        $this->view->generate('template.php', 'view_auth.php', null);
    }

    static function check(){
        if(isset($_SESSION['auth']) && !empty($_SESSION['auth']) && isset($_SESSION['id']) && !empty($_SESSION['id'])){
            return true;
        }
        return false;
    }

    static function User($id){

    }

    function out(){
        unset($_SESSION['auth']);
        unset($_SESSION['id_user']);
        unset($_SESSION['hash']);
        //setcookie('hash','');
    }
}