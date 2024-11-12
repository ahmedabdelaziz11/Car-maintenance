<?php

namespace MVC\core;

class session
{

    public static function Start()
    {
        if (session_status() == PHP_SESSION_NONE) {
            $weekInSeconds = 7 * 24 * 60 * 60;
    
            ini_set('session.gc_maxlifetime', $weekInSeconds);
    
            session_set_cookie_params([
                'lifetime' => $weekInSeconds,
                'path' => '/',
                'secure' => isset($_SERVER['HTTPS']),
                'httponly' => true, 
                'samesite' => 'Lax',
            ]);
    
            ini_set('session.gc_probability', 1);
            ini_set('session.gc_divisor', 100);
    
            @session_start();
        }
    }

    public static function Set($key,$value)
    {
        $_SESSION[$key] = $value;
    }

    public static function Get($key)
    {
        if(isset($_SESSION[$key]))
        return $_SESSION[$key];
    }

    public static function Stop()
    {
        session_destroy();
    }
}

