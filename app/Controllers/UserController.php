<?php


namespace MVC\controllers;

use MVC\core\controller;
use MVC\core\Session;
use MVC\models\user;

class UserController extends controller{

    public function index(){
        $userModel = new user();
        print_r( $userModel->getAllUsers());
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            
            if (empty($name) || empty($email) || empty($password)) {
                echo "All fields are required!";
                return;
            }
            $user = new User();
            $result = $user->register([
                'name'     => $name,
                'email'    => $email,
                'password' => $password,
                'role'     => 3
            ]);
            if ($result === "Registration successful!") {
                header('Location: /cars/public/user/login');
                exit;
            } else {
                echo $result;
            }
        }

        $this->view('auth/register',[]);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            if (empty($email) || empty($password)) {
                echo "Email and password are required!";
                return;
            }
            
            $user = new User();
            $authenticatedUser = $user->select(['id', 'email', 'password', 'role'])
                ->where('email', '=', $email)
                ->row();

            if ($authenticatedUser && password_verify($password, $authenticatedUser['password'])) {
                Session::Set('user', [
                    'id' => $authenticatedUser['id'],
                    'email' => $authenticatedUser['email'],
                    'role' => $authenticatedUser['role']
                ]);
                
                header('Location: /cars/public/');
                exit;
            } else {
                echo 'Invalid login credentials';
            }
        }
        $this->view('auth/login',[]);
    }

    public function logout() {
        Session::Stop();
        header('Location: /');
        exit;
    }
}