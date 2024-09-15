<?php

namespace MVC\models;

use MVC\core\model;

class user extends model{

    private $table = "users";

    public function GetAllUsers(){
        $data =  $this->select($this->table,"*")->all(); 
        return $data;
    }
}