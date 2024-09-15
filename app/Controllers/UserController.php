<?php


namespace MVC\controllers;

use MVC\core\controller;
use MVC\models\user;

class UserController extends controller{
    public function index(){
        $userModel = new user();
        print_r( $userModel->getAllUsers());
    }
}