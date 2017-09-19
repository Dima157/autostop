<?php
class Model_Account extends Model{
    private $login, $pass, $error;

    function __construct($login = null, $pass = null)
    {
        parent::__construct();
        $this->login = $login;
        $this->pass = $pass;
    }

    function login(){
        $res = $this->pdo->select('account', ['login', 'pass'], [$this->login, $this->pass]);
        if(count($res) > 0){
            $_SESSION['login'] = $this->login;
            $_SESSION['auth'] = true;
            $_SESSION['id'] = $res[0]['fk_user'];
        }else{
            $this->error = 'Неверно';
            return false;
        }
        return true;
    }

    function getUser($id){
        $query = "select * from users where id='$id'";
        $res = $this->pdo->query($query)->fetchAll();
        $res = $this->pdo->select('users', 'id', $id);
        if($res > 0){
            //return new Model_User()
        }
    }

    function getError(){
        return $this->error;
    }

    function logout(){
        unset($_SESSION['login']);
        unset($_SESSION['auth']);
        unset($_SESSION['id']);
    }
}