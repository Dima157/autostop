<?php
class Model_Vote extends Model{
    private $say_yes, $say_no, $new_waypoints, $id;

    function __construct( $new_waypoints = null, $say_yes = null, $say_no = null, $id = null)
    {
        parent::__construct();
        $this->say_yes = $say_yes;
        $this->say_no = $say_no;
        $this->new_waypoints = $new_waypoints;
        $this->id = $id;
    }

    function check(){

    }

    function add_waypoints($id_group, $mass){
        $info = [
            'fk_group' => $id_group
        ];
        $this->pdo->insert('vote', $info);
        $res = $this->pdo->selectLastElement('vote', 'id_vote');
        $id_vote = $res[0]['id_vote'];
        for($i = 0; $i < count($mass); $i++){
            $info = [
                'lat' => $mass[$i]['lat'],
                'lng' => $mass[$i]['lng'],
                'fk_vote' => $id_vote
            ];
            var_dump($info);
            $this->pdo->insert('waipoints_for_vote', $info);
        }
    }

    static function getVote($id_group){
        $db = DB::PDO();
        $res = $db->select('vote','fk_group', $id_group);
        $id = $res[0]['id_vote'];
        $res = $db->select('waipoints_for_vote', 'fk_vote', $id);
        $waypoints = [];
        if($res){
            for($i = 0; $i < count($res); $i++){
                $waypoints[] = [
                    'lat' => $res[$i]['lat'],
                    'lng' => $res[$i]['lng']
                ];
            }
        }
        $res = $db->select('votes', ['fk_vote', 'answer'], [$id, 'yes']);
        $say_yes = 0;
        if($res){
            $say_yes = count($res);
        }
        $res = $db->select('votes', ['fk_vote', 'answer'], [$id, 'no']);
        $say_no = 0;
        if($res){
            $say_no = count($res);
        }
        //$res = $db->select('votes')
        return new Model_Vote($waypoints, $say_yes, $say_no, $id);
    }

    function getWaypoints(){
        return $this->new_waypoints;
    }

    function check_vote($id_group){
        $res = $this->pdo->select('vote', 'fk_group', $id_group);
        if($res){
            return true;
        }
        return false;
    }

    function checkVotesUser(){
        $id = $_SESSION['id'];
        $res = $this->pdo->select('votes', ['fk_user', 'fk_vote'], [$id, $this->id]);
        if($res){
            return true;
        }
        return false;
    }

    function addAnswer($answer){
        $id = $_SESSION['id'];
        $mass = [
            'answer' => $answer,
            'fk_user' => $id,
            'fk_vote' => $this->id
        ];
        $this->pdo->insert('votes', $mass);
    }

    function checkAnswerUser(){
        $id = $_SESSION['id'];
        $res = $this->pdo->select('votes', ['fk_user', 'fk_vote'], [$id, $this->id]);
        if($res){
            return false;
        }
        return true;
    }

    function getStatistic($count_user){
        $res = $this->pdo->select('votes', ['fk_vote', 'answer'], [$this->id, 1]);
        $say_yes = count($res);
        $res = $this->pdo->select('votes', ['fk_vote', 'answer'], [$this->id, 2]);
        $say_no = count($res);
        $say_yes_percent = $say_yes / $count_user * 100;
        $say_no_percent = $say_no / $count_user * 100;
        $mass = [
            'yes' => $say_yes_percent,
            'no' => $say_no_percent,
            'count_yes' => $say_yes,
            'count_no' => $say_no
        ];
        return $mass;
    }

    function close($say_yes, $say_no, $count_user, $map, $id_group){
        $all_votes = $say_no + $say_yes;
        if($count_user == $all_votes){
            if($say_yes > $say_no){
                $map->addWaypoints($this->new_waypoints);
                $this->pdo->delete('waipoints_for_vote', 'fk_vote', $this->id);
                $this->pdo->delete('vote', 'fk_group', $id_group);
                $this->pdo->delete('votes', 'fk_vote', $this->id);
            }
        }

    }

}