<?php
class Controller_Register extends Controller{
    private $error = 'Заполните все поля формы';
    private $model;
    function __construct()
    {
        parent::__construct();
        $this->model = new Model_Register();
    }

    function index()
    {
        $login = strip_tags($_POST['login']);
        $name = strip_tags($_POST['name_user']);
        $surname = strip_tags($_POST['surname_user']);
        $birthday = strip_tags($_POST['birthday']);
        $city = strip_tags($_POST['city_user']);
        $email = strip_tags($_POST['email_user']);
        $pass = strip_tags($_POST['pass_user']);
        $pass_again = strip_tags($_POST['pass_again_user']);
        echo $name.' '.$surname.' '.$city.' '.$email.' '.$pass.' '.' '.$pass_again;
        if(empty($name) || !isset($name) || empty($surname) || !isset($surname) || empty($city) || !isset($city) || empty($email) || !isset($email) || empty($pass) || !isset($pass) || empty($pass_again) || !isset($pass_again) || !isset($login) || empty($login) || !isset($birthday) || empty($birthday)){
            $this->view->generate(null, 'view_register_result.php', $this->error);
            return false;
        }

        $this->model = new Model_Register();
        $this->model->setInfo($login ,$name, $surname, $birthday, $city, $email, $pass, $pass_again);
        if($this->model->ValidForm()){
            if($this->model->checkUsers() == false){
                $this->view->generate(null, 'view_register_result.php', $this->model->getError());
            }else {
                if($this->model->checkLogin() == false){
                 $this->view->generate(null, 'view_register_result.php', $this->model->getError());
                }else {
                    $this->model->insert();
                    $message = 'Перейдите на свою почту для подтверждения реестрации';
                    $this->view->generate(null, 'view_register_result.php', $message);
                }
            }
        }else{
            $this->view->generate(null, 'view_register_result.php', $this->model->getError());
        }
    }

    function hash($param){
        $hash = $param[0];
        $email = base64_decode($param[1]);
        $this->model->pushHash($hash, $email);
        //$this->model->pushHash();
    }



}