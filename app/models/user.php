<?php

namespace MVC\models;

use MVC\core\model;

class user extends model{

    public function __construct()
    {
        parent::__construct();  
        $this->table = "users";
    }

    public function GetAllUsers(){
        $data =  $this->select()->all(); 
        return $data;
    }

    public function register($data)
    {

        $existingUser = $this->select()->where('email', '=', $data['email'])->row();
        if ($existingUser) {
            return "Email already registered!";
        }

        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

        $this->insert([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password']
        ])->execute();

        return "Registration successful!";
    }
}