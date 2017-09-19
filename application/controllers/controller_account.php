<?php
class Controller_Account extends Controller{
    private $model;
    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        echo $_SESSION['auth'].'<br>';
        echo $_SESSION['id'];
        $this->view->generate('template.php', 'view_auth.php', null);
    }

    function login(){
        $login = $_POST['login'];
        $pass = $_POST['pass'];
        $this->model = new Model_Account($login, $pass);
        if($this->model->login() == false) {
            echo $this->model->getError();
        }else{
            echo true;
        }
            //$this->view->generate(null, null, $e->getMessage());
    }

    function logout(){
        $this->model = new Model_Account();
        $this->model->logout();
        header('Location: /account');
    }
}