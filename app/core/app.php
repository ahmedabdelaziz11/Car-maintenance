<?php

namespace MVC\core;

class app
{

    private $controller = 'Home';
    private $method = 'index';
    private $params = [];

    public function __construct()
    {
        Session::Start();
        $this->url();
        $this->render();
    }


    private function url()
    {

        if (!empty($_SERVER['QUERY_STRING'])) {
            $url =  explode("/", $_SERVER['QUERY_STRING']);

            $this->controller = isset($url[0]) ? $url[0] . "Controller" : "HomeController";

            $this->method = isset($url[1]) ? $url[1] : "index";
            unset($url[0], $url[1]);

            $this->params = array_values($url);
        } else {
            $this->controller = 'HomeController';
            $this->method = 'index';
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
