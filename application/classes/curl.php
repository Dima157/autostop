<?php
class Curl{
    private $url, $curl;

    function __construct($url)
    {
        $this->url = $url;
    }

    function initCurl(){
        $this->curl = curl_init();
    }

    function setOpt(){
        curl_setopt($this->curl, CURLOPT_URL, $this->url);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
    }

    function getInfo(){
        $res = curl_exec($this->curl);
        return $res;
    }

    function curlClose(){
        curl_close($this->curl);
    }
}