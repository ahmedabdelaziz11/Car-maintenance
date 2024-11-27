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

    public function GetAllAdmins(){
        $data =  $this->where('role','!=',3)->select(['id','name','email','role'])->all(); 
        return $data;
    }

    public function getById($id)
    {
        return $this->select()->where('id', '=', $id)->row();
    }

    public function getByEmail($email, $id = null)
    {
        $query = $this->select()->where('email', '=', $email);
    
        if ($id !== null) {
            $query->where('id', '!=', $id);
        }
    
        return $query->row();
    }

    public function deleteRow($id)
    {
        return $this->delete($id)->execute();
    }

    public function updateRow($data)
    {
        $id = $data['id'];
        unset($data['id']);
        $this->update($data)->where('id', '=', $id);
        return $this->execute();
    }

    public function create($data)
    {
        return $this->insert($data)->execute();
    }

    public function register($data)
    {

        $existingUser = $this->select()->where('email', '=', $data['email'])->row();
        if ($existingUser) {
            return "Email already registered!";
        }

        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

        $this->insert([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => $data['password'],
            'role'     => $data['role'],
        ])->execute();

        return "Registration successful!";
    }

    public function getAllowedContactTypes($adminId) {
        $admin = $this->select()->where('id', '=', $adminId)->row();
        return json_decode($admin['contact_types'], true) ?? [];
    }

    public function GetAdminDashboardData(){
        $this->sql = "SELECT count(*) as total FROM offers";
        $offerCount = $this->row()['total'];
        $this->sql = "SELECT count(*) as total FROM users WHERE role = 3";
        $userCount = $this->row()['total'];
        $this->sql = "SELECT count(*) as total FROM offer_comments";
        $commentCount = $this->row()['total'];
        $this->sql = "SELECT count(*) as total FROM reports";
        $reportCount = $this->row()['total'];
        $this->sql = "SELECT count(*) as total FROM favorites";
        $favoriteCount = $this->row()['total'];
        return[
            'offerCount' => $offerCount,
            'userCount' => $userCount,
            'commentCount' => $commentCount,
            'reportCount' => $reportCount,
            'favoriteCount' => $favoriteCount
        ];
    }
}