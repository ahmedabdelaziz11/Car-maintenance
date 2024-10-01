<?php

namespace MVC\core;

use MVC\models\notification;

class notifications
{

    public static function userNotifications()
    {
        if (session::get('user')) {
            $notificationModel = new notification();
            return $notificationModel->getAll();
        }
        return [];
    }
}

