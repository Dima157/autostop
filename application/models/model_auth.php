<?php
class Model_Auth extends Model{
    //private $error, $email, $pass;
    static $db;
    function __construct()
    {
        parent::__construct();
        self::$db = DB::PDO();
    }

    static function check(){
        if(isset($_SESSION['auth']) && !empty($_SESSION['auth']) && isset($_SESSION['id']) && !empty($_SESSION['id'])){
            return true;
        }
        return false;
    }

    static function User(){
        $id = $_SESSION['id'];
        $query = "select * from users where id='$id'";
        $avatar = Model_Avatar::getAvatar($id);
        $photos = Model_Photo::getPhotosModel($id);
        $db = DB::PDO();
        $res = $db->select('users', 'id', $id);
        if(count($res) > 0){
            return new Model_User($id, $res[0]['name'], $res[0]['surname'], $res[0]['city'], $res[0]['birthday'], $res[0]['email'], $avatar, $photos);
        }

    }

    static function currentUser($id){
        $id_user = $_SESSION['id'];
        if($id_user == $id){
            return true;
        }
        return false;
    }

}