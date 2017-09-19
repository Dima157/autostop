<?php
class Model_Map extends Model{
    private $marker_start, $marker_end, $waypoints, $error, $id;
    function __construct($marker_start = null, $marker_end = null, $waypoints = null, $id = null)
    {
        parent::__construct();
        $this->marker_start = $marker_start;
        $this->marker_end = $marker_end;
        $this->waypoints = $waypoints;
        $this->id = $id;
    }

    static function getMap($id){
        $db = DB::PDO();
        $res = $db->select('maps', 'fk_group', $id);
        $waypoints = [];
        $id_map = '';
        if($res){
            $id_map = $res[0]['id_map'];
            $marker_start = [
                'lat' => $res[0]['lat_start'],
                'lng' => $res[0]['lng_start']
            ];
            $marker_end = [
                'lat' => $res[0]['lat_end'],
                'lng' => $res[0]['lng_end']
            ];
            $res = $db->select('waypoints', 'fk_map', $id_map);
            if($res){
                for($i = 0; $i < count($res); $i++){
                    $mass = [
                        'lat' => $res[$i]['lat'],
                        'lng' => $res[$i]['lng']
                    ];
                    $waypoints[] = $mass;
                }
            }
            return new Model_Map($marker_start, $marker_end, $waypoints, $id_map);
        }
    }

    function getMarkerStart(){
        return $this->marker_start;
    }

    function getMarkerEnd(){
        return $this->marker_end;
    }

    function getWaypoints(){
        return $this->waypoints;
    }

    function getError(){
        return $this->error;
    }

    function validDate(){
        if(!isset($this->marker_start['lat']) || !isset($this->marker_start['lng']) || empty($this->marker_start['lat']) || empty($this->marker_start['lng']) || !isset($this->marker_end['lat']) || !isset($this->marker_end['lng']) || empty($this->marker_end['lat']) || empty($this->marker_end['lng'])){
            $this->error = 'Добавте точки';
            return false;
        }
        return true;
    }

    function insert($id_group){
        $mass = [
            'lat_start' => $this->marker_start['lat'],
            'lng_start' => $this->marker_start['lng'],
            'lat_end' => $this->marker_end['lat'],
            'lng_end' => $this->marker_end['lng'],
            'fk_group' => $id_group
        ];
        $this->pdo->insert('maps', $mass);
    }

    function addWaypoints($waypoints){
        for($i = 0; $i < count($waypoints); $i++){
            $mass = [
                'lat' => $waypoints[$i]['lat'],
                'lng' => $waypoints[$i]['lng'],
                'fk_map' => $this->id
            ];
            $this->pdo->insert('waypoints', $mass);
        }
    }
}