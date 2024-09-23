<?php


namespace MVC\controllers;

use MVC\core\controller;

class HomeController extends controller{

    public function index(){
        $this->view('index',[]);
    }
}