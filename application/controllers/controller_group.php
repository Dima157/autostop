<?php
class Controller_Group extends Controller{
    private $model;
    function __construct()
    {
        parent::__construct();
    }

    function index(){
        $groups = Model_Group::getAllGroups();
        $this->view->generate('template.php', 'view_group.php', $groups);
    }

    function create(){
        $this->view->generate('template.php', 'view_create.php', null);
    }

    function show($id){
        $this->model = Model_Group::getGroup($id[0]);
        $check = $this->model->checkParticipants();
        $admin = false;
        if(!$check){
            $check = $this->model->checkAdmin();
            if($check){
                $admin = true;
            }
        }
        $parser = new Model_Parse($this->model->getMap()->getMarkerStart(), $this->model->getMap()->getMarkerEnd(), $this->model->getMap()->getWaypoints());
        $parser->parseCity();
        $parser->getNameCity();
        $r = $parser->getPlace("Львовская область");
        $mass = [
            'param' => $this->model,
            'enter' => $check,
            'admin' => $admin,
            'parser' => $parser,
            'r' => $r
        ];
        $this->view->generate('template.php', 'view_show_group.php', $mass);
    }

    function add_ban(){
        $id = $_POST['id_user'];
        $id_gr = $_POST['id_group'];
        echo $id_gr;
        $model = Model_Group::getGroup($id_gr);
        $model->addBanUser($id);
    }

    function create_group(){
        $info = json_decode($_POST['info']);
        $name = $info->name_group;
        $count = $info->count_users;
        $date_start = $info->start;
        $marker_start = [
            'lat' => $info->markers[0]->lat,
            'lng' => $info->markers[0]->lng
        ];
        $marker_end = [
            'lat' => $info->markers[1]->lat,
            'lng' => $info->markers[1]->lng
        ];
        $this->model = new Model_Group(null ,$name, $count, $date_start);
        $map = new Model_Map($marker_start, $marker_end);
        if($this->model->validDate()) {
            if($map->validDate()) {
                $this->model->insert();
                $id = $this->model->getLastId();
                $map->insert($id);
                $result = [
                    'create' => true,
                    'url' => "/group/show/$id"
                ];
                echo json_encode($result);
            }else{
                $result = [
                    'create' => false,
                    'error' => $map->getError()
                ];
                echo json_encode($result);
            }
        }else{
            $result = [
                'create' => false,
                'error' => $count
            ];
            echo json_encode($result);
        }

    }

    function add(){
        $id_group = $_POST['id_group'];
        $id_user = $_SESSION['id'];
        $this->model = Model_Group::getGroup($id_group);
        $this->model->addToGroup($id_user);
    }



}
