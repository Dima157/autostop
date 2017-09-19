<?php
class Controller_Index extends Controller{
    function index(){
        $this->view->generate('template.php','view_index.php', null);
    }
}