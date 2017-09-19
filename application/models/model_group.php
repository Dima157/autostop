<?php
class Model_Group extends Model{
    private $id, $name, $users_count, $date_start, $users, $maps, $creator, $vote, $chat, $photos, $error;

    function __construct($id = null, $name = null, $users_count = null, $date_start = null, $maps = null, $users = null, $creator = null, $vote = null, $chat = null){
        parent::__construct();
        $this->id = $id;
        $this->name = $name;
        $this->users_count = $users_count;
        $this->date_start = $date_start;
        $this->maps = $maps;
        $this->users = $users;
        $this->creator = $creator;
        $this->chat = $chat;
        $this->vote = $vote;
    }

    function getCount(){
        return $this->users_count;
    }

    function getId(){
        return $this->id;
    }

    function getMap(){
        return $this->maps;
    }

    function getDateStart(){
        return $this->date_start;
    }

    static function getAllGroups(){
        $db = DB::PDO();
        $res = $db->select('groups');
        $mass = [];
        if($res){
            for($i = 0; $i < count($res); $i++){
                $group = new Model_Group($res[$i]['id_group'], $res[$i]['name'], $res[$i]['count_participants'], $res[$i]['data_start']);
                $group->pdo =null;
                $mass[] = $group;
            }
        }
        return $mass;
    }

    function getParticipants(){
        return $this->users;
    }

    function getParticipantCount(){
        return count($this->users);
    }

    function check(){
        if(count($this->users) < $this->users_count){
            return true;
        }
        return false;
    }

    function checkAdmin(){
        $id = $_SESSION['id'];
        $res = $this->pdo->select('groups', 'creator_id', $id);
        if($res){
            return true;
        }
        return false;
    }

    function addBanUser($id){
        $param = [
            'fk_group' => $this->id,
            'fk_user' => $id
        ];
        var_dump($this->id);
        $this->pdo->insert('ban', $param);
        $this->pdo->delete('participants', ['fk_user', 'fk_group'], [$id, $this->id]);
    }


    function checkParticipants(){
        $param = ['fk_group', 'fk_user'];
        $property = [$this->getId(), $_SESSION['id']];
        $res = $this->pdo->select('participants', $param, $property);
        if($res){
            return true;
        }
        return false;
    }

    function gerError(){
        return $this->error;
    }

    function getName(){
        return $this->name;
    }

    function validDate(){
        if(!isset($this->name) || empty($this->name)){
            $this->error = 'Введите имя';
            return false;
        }
        elseif(!isset($this->users_count) || empty($this->users_count)){
            $this->error = 'Добавте количество учасников автостопа';
            return false;
        }
        elseif(!isset($this->date_start) || empty($this->date_start)){
            $this->error = $this->date_start;
            return false;
        }
        return true;
    }

    function insert(){
        $creator_id = $_SESSION['id'];
        $mass = [
            'name' => $this->name,
            'count_participants' => $this->users_count,
            'data_start' => $this->date_start,
            'status' => 'action',
            'creator_id' => $creator_id
        ];
        $this->pdo->insert('groups', $mass);
    }

    function getLastId(){
        $res = $this->pdo->selectLastElement('groups', 'id_group');
        return $res[0]['id_group'];
    }

    function getCreator(){
        return $this->creator;
    }

    static function getGroup($id){
        $db = DB::PDO();
        $res = $db->select('groups', 'id_group', $id);
        $map = Model_Map::getMap($id);
        $users_id = $db->select('participants', 'fk_group', $id);
        $vote = Model_Vote::getVote($id);
        $chat = Model_Chat::getChat($id);
        $all_users = [];
        for($i = 0; $i < count($users_id); $i++){
            $user = Model_User::getUser($users_id[$i]['fk_user']);
            $all_users[] = $user;
        }
        if($res){
            $creator = Model_User::getUser($res[0]['creator_id']);
            return new Model_Group($res[0]['id_group'], $res[0]['name'], $res[0]['count_participants'], $res[0]['date_start'], $map, $all_users, $creator, $vote, $chat);
        }
    }

    function getChat(){
        return $this->chat;
    }

    function getVote(){
        return $this->vote;
    }

    function addToGroup($id_user){
        //echo $this->getId();//7//
        if($this->check()){
            $mass = [
                'fk_user' => $id_user,
                'fk_group' => $this->id
            ];
            $this->pdo->insert('participants', $mass);
        }
    }
}