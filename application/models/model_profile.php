<?php
class Model_Profile extends Model{
    private $user;

    function set_user($id){
        $this->user = Model_User::get_user($id);
        return $this->user;
    }

}