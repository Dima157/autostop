<?php
class Model_Chat extends Model{
    private $message, $user;

    function __construct($mess = null, $user = null)
    {
        parent::__construct();
        $this->user = $user;
        $this->message = $mess;
    }

    function add($mess, $id, $id_group){
        $mass = [
            'message' => $mess,
            'fk_user' => $id,
            'fk_group' => $id_group
        ];
        $this->pdo->insert('chat', $mass);
    }

    function getMess(){
        return $this->message;
    }

    function getUser(){
        return $this->user;
    }

    static function getChat($id_group){
        $db = DB::PDO();
        $res = $db->select('chat', 'fk_group', $id_group);
        $mess = [];
        $allUser = [];
        if($res){
            for($i = 0; $i < count($res); $i++){
                $mess[] = $res[0]['message'];
                $user = Model_User::getUser($res[$i]['fk_user']);
                $user->pdo = null;
                $allUser[] = $user;
            }
        }
        return new Model_Chat($mess, $allUser);
    }
}