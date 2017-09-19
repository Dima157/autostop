<?php
use Sunra\PhpSimple\HtmlDomParser;
header('Content-Type: text/html; charset=utf-8');
class Model_Parse{
    private $url_place = 'http://100travels.com.ua/category/oblasti/';
    private $start, $end, $waypoints, $api = "AIzaSyCH6nHRmOU7pux4sUM92tPBQG984iJJrjs", $city = [],
$all_city = [
        'Volyns\'ka oblast' => 'Волынская область',
        'Vinnyts\'ka oblast' => 'Винницкая область',
        'Dnipropetrovsk Oblast' => 'Днепропетровкая область',
        'Donetsk Oblast' => 'Денецкая область',
        'Zhytomyrs\'ka oblast' => 'Житомирская область',
        'Zaporiz\'ka oblast' => 'Запорожская область',
        'Zakarpats\'ka oblast' => 'Закарпатская область',
        'Ivano-Frankivs\'ka oblast' => 'Ивано-Франковкая область',
        'Kyivs\'ka oblast' => 'Киевская область',
        'Lviv Oblast' => 'Львовская область',
        'Ternopil\'s\'ka oblast' => 'Тернопольская область',
        'Khmel\'nyts\'ka oblast' => 'Хмельницкая область',
        'Kirovohrads\'ka oblast' => 'Кировоградская область',
        'Chernivets\'ka oblast' => 'Черновецкая область',
        'Mykolaivs\'ka oblast' => 'Николаевская область',
        'Khersons\'ka oblast' => 'Херсонская область',
        'Poltavs\'ka oblast' => 'Полтавская область',
        'Luhans\'ka oblast' => 'Луганская область',
        'Chernihivs\'ka oblast' => 'Черниговкая область',
        'Sums\'ka oblast' => 'Сумская область',
        'Rivnens\'ka oblast' => 'Ровенская область',
        'Kharkiv Oblast' => 'Харьковская область',
        'Odessa Oblast' => 'Одесская область',
        'Cherkas\'ka oblast' => 'Черкасская область'
    ], $city_name,
$build_url = [
        'Винницкая область' => 'vinnickaya/',
        'Волынская область' => 'volynskaya/',
        'Днепропетровкая область' => 'dnepropetrovskaya/',
        'Денецкая область' => 'doneckaya/',
        'Житомирская область' => 'zhitomirskaya/',
        'Закарпатская область' => 'zakarpatskaya/',
        'Запорожская область' => 'zaporozhskaya/',
        'Ивано-Франковкая область' => 'ivano-frankovskaya/',
        'Киевская область' => 'kievskaya/',
        'Кировоградская область' => 'kirovogradskaya/',
        'Луганская область' => 'luganskaya/',
        'Львовская область' => 'lvovskaya-oblasti/',
        'Николаевская область' => 'nikolaevskaya/',
        'Одесская область' => 'odesskaya/',
        'Полтавская область' => 'poltavskaya/',
        'Ровенская область' => 'rovenskaya/',
        'Сумская область' => 'sumskaya/',
        'Тернопольская область' => 'ternopolskaya/',
        'Харьковская область' => 'xarkovskaya/',
        'Херсонская область' => 'xersonskaya/',
        'Хмельницкая область' => 'xmelnickaya/',
        'Черкасская область' => 'cherkasskaya/',
        'Черновецкая область' => 'chernovickaya/',
        'Черниговкая область' => 'chernigovskaya/'
    ];

    function __construct($start = null, $end = null, $waypoints = null)
    {
        $this->start = $start;
        $this->end = $end;
        $this->waypoints = $waypoints;

    }
    function get(){
        return $this->city;
    }
    function parseCity(){
        $two_points = [$this->start, $this->end];
        $all_points = array_merge($two_points, $this->waypoints);
        for($i = 0; $i < count($all_points); $i++){
            $lat = $all_points[$i]['lat'];
            $lng = $all_points[$i]['lng'];
            $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$lng&key=$this->api";
            $curl = new Curl($url);
            $curl->initCurl();
            $curl->setOpt();
            $res = $curl->getInfo();
            $curl->curlClose();
            $res = json_decode($res);
            $res = $res->results[2]->address_components[0]->long_name;
            $this->city[] = $res;
        }

    }
    function getNameCity(){
        $mass = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
        for($i = 0; $i < count($this->city); $i++){
            if(is_string($this->city[$i])) {
                foreach ($this->all_city as $key => $val) {
                    if ($this->city[$i] == $key || substr($this->city[$i], 0, 5) == substr($key, 0, 3)) {
                        $this->city_name[] = $val;
                    }
                }
            }
        }
    }
    function getCity(){
        return $this->city_name;
    }

    function getPlace($name){
        foreach($this->build_url as $key => $val){
            if($name == $key){
                $query = $val;
            }
        }
        if(isset($query) && !empty($query)) {
            $query_url = $this->url_place . $query;
            $curl = new Curl($query_url);
            $curl->initCurl();
            $curl->setOpt();
            $str = $curl->getInfo();
            $curl->curlClose();
            $dom = HtmlDomParser::str_get_html( $str );
            $res = $dom->find('.txt-box');
//$mass = [];
            $res = $dom->find('.place-lst');
            return $res;
        }
    }


}