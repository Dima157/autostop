<?php
class Controller_Vote extends Controller{
    function index()
    {

    }
    function waypoints_vote(){
        $id = $_POST['id'];
        $vote = Model_Vote::getVote($id);
        $res = $vote->getWaypoints();
        echo json_encode($res);
    }

    function vote_create(){
        $id_group = $_POST['id'];
        $data = json_decode($_POST['data']);
        $mass = [];
        for($i = 0; $i < count($data); $i++){
            $mass[] = [
                'lat' => $data[$i]->location->lat,
                'lng' => $data[$i]->location->lng
            ];
        }

        $vote = new Model_Vote();
        $vote->add_waypoints($id_group, $mass);
    }

    function get_vote_waypoints(){
        $id_group = $_POST['id_group'];
        $vote = Model_Vote::getVote($id_group);
        $waypoints = $vote->getWaypoints();
        echo json_encode($waypoints);
    }

    function choose(){
        $data = json_decode($_POST['data']);
        $id_group = $data->id_group;
        $vote = Model_Vote::getVote($id_group);
        if($vote->checkAnswerUser()) {
            $vote->addAnswer($data->answer);
        }
        $group = Model_Group::getGroup($id_group);
        $count_user = $group->getParticipantCount();
        $count_user += 1;
        $result = $vote->getStatistic($count_user);
        $map = Model_Map::getMap($id_group);
        $vote->close($result['count_yes'], $result['count_no'], $count_user, $map, $id_group);
        echo json_encode($result);
    }
}