<?php
class Controller_Profile extends Controller{
    private $model;
    function __construct()
    {
        parent::__construct();
        if(Model_Auth::check()) {
            $this->model = new Model_Profile();
        }
    }

    function index(){
        $user = Model_Auth::User();
        $this->view->generate('template.php', 'view_profile.php', $user);
    }

    function edit_profile(){

    }

    function show($id){
        if(!Model_Auth::check()){
            header('Location: /account');
        }
        $id = $id[0];
        $user = Model_User::getUser($id);
        $this->view->generate('template.php', 'view_profile.php', $user);
    }
}