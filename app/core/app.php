<?php

namespace MVC\core;

class app
{

    private $controller = 'Home';
    private $method = 'index';
    private $params = [];

    public function __construct()
    {
        session::Start();
        $this->url();
        $this->render();
    }


    private function url()
    {
        $url = $_SERVER['QUERY_STRING'];
        if (!empty($_SERVER['QUERY_STRING']) && !(count(explode("/", explode("&", $url)[0])) ==  1 && str_contains(explode("/", explode("&", $url)[0])[0],'page='))) {
            $url = explode("&", $url)[0];
            $url = explode("/", $url);
            $this->controller = isset($url[0]) ? $url[0] . "Controller" : "HomeController";
            $this->method = isset($url[1]) ? $url[1] : "index";
            unset($url[0], $url[1]);
            $this->params = array_values($url);
        } else {
            $url = explode("&", $url)[0];
            $url = explode("/", $url);
            $this->controller = 'HomeController';
            $this->method = 'index';
            $this->params = array_values($url);
        }
    }

    private function render()
    {
        $controller = "MVC\Controllers\\" . $this->controller;
        if (class_exists($controller)) {

            $controller = new $controller;

            if (method_exists($controller, $this->method)) {


                call_user_func_array([$controller, $this->method], $this->params);
            } else {
                echo 'method not exist';
            }
        } else {
            echo 'class not exist';
        }
    }
}
