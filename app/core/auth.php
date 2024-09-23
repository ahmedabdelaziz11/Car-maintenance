<?php
namespace MVC\core;

class Auth {

    public static function check() {
        if (!isset($_SESSION['user'])) {
            header('Location: /user/login');
            exit;
        }
    }

    public static function isAdmin() {
        if ($_SESSION['user']['role'] != 'admin') {
            echo 'You do not have permission to access this page.';
            exit;
        }
    }

    public static function isSupervisor() {
        if ($_SESSION['user']['role'] != 'supervisor') {
            echo 'You do not have permission to disable ads.';
            exit;
        }
    }
}
