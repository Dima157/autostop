<?php
class Controller_Map extends Controller{
    private $model;
    function __construct()
    {
        parent::__construct();
        $this->model = new Model_Map();
    }

    function index(){

    }

    function get_location_map(){
        $name_country = $_POST['country'];
        $location = $this->model->getCenter($name_country);
        echo json_encode($location);
    }

    function get($param = null){
        $id = $_POST['id'];
        $this->model = Model_Map::getMap($id);
        $marker_start = $this->model->getMarkerStart();
        $marker_end = $this->model->getMarkerEnd();
        $waypoints = $this->model->getWaypoints();
        $mass = [
            'marker_start' => $marker_start,
            'marker_end' => $marker_end,
            'waypoints' => $waypoints
        ];
        echo json_encode($mass);
    }


}