<?php

namespace MVC\controllers;

use MVC\core\controller;
use MVC\core\session;
use MVC\models\notification;

class NotificationController extends controller{

    public function __construct()
    {
        if(!session::Get('user'))
        {
            header('Location: ' . BASE_URL . '/user/login');
            exit;
        }
    }
    
    public function index()
    {
        $notificationModel = new notification();
        
        $notifications = $notificationModel->getAll();
        
        $this->view('notifications/index', ['notifications' => $notifications]);
    } 
}