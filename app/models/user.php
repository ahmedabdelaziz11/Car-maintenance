<?php

namespace MVC\models;

use MVC\core\model;
use MVC\core\session;

class user extends model{

    public function __construct()
    {
        parent::__construct();  
        $this->table = "users";
    }

    public function GetAllAdmins(){
        $data =  $this->select(['id','name','email','role','phone'])->all(); 
        return $data;
    }

    public function getById($id)
    {
        return $this->select()->where('id', '=', $id)->row();
    }

    public function getByUsername($username)
    {
        $userId = null;
        if(isset(session::Get('user')['id'])){
            $userId = session::Get('user')['id'];
        }
        $sql = $this->select()->where('name', '=', $username);
        if($userId)
        {
            $sql->where('id','!=',$userId);
        }
        return $sql->row();
    }

    public function getByPhone($phone)
    {
        $userId = null;
        if(isset(session::Get('user')['id'])){
            $userId = session::Get('user')['id'];
        }
        $sql = $this->select()->where('phone', '=', $phone);
        if($userId)
        {
            $sql->where('id','!=',$userId);
        }
        return $sql->row();
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
            'phone'    => $data['phone'],
            'password' => $data['password'],
            'role'     => $data['role'],
            'otp'      => rand(100000,999999),
            'email_otp' => rand(100000,999999),
            'is_phone_verified' => 0,
            'is_email_verified' => 0,
        ])->execute();

        return "Registration successful!";
    }

    public function getAllowedContactTypes($adminId) {
        $admin = $this->select()->where('id', '=', $adminId)->row();
        $types = $admin['contact_types'] ?? '';
        return json_decode($types, true) ?? [];
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