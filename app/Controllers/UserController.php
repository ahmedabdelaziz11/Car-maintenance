<?php


namespace MVC\controllers;

use MVC\core\controller;
use MVC\core\session;
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
                $errorMessage = "جميع الحقول مطلوبة!";
                $this->view('auth/register',['errorMessage' => $errorMessage]);
            }else{
                $user = new User();
                $result = $user->register([
                    'name'     => $name,
                    'email'    => $email,
                    'password' => $password,
                    'role'     => 3
                ]);
                if ($result === "Registration successful!") {
                    header('Location: ' . BASE_URL . '/user/login');
                    exit;
                } else {
                    $errorMessage = $result;
                    $this->view('auth/register',['errorMessage' => $errorMessage]);
                }
            }
        }

        $this->view('auth/register',[]);
    }

    public function login() {
        $errorMessage = "";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            if (empty($email) || empty($password)) {
                $errorMessage = "Email and password are required!";
            }else{
                $user = new User();
                $authenticatedUser = $user->select(['id', 'email', 'password', 'role'])
                    ->where('email', '=', $email)
                    ->row();
    
                if ($authenticatedUser && password_verify($password, $authenticatedUser['password'])) {
                    session::Set('user', [
                        'id' => $authenticatedUser['id'],
                        'email' => $authenticatedUser['email'],
                        'role' => $authenticatedUser['role']
                    ]);
                    
                    header('Location: ' . BASE_URL . '/');
                    exit;
                } else {
                    $errorMessage = 'بيانات اعتماد تسجيل الدخول غير صالحة';
                }
            }
        }
        $this->view('auth/login',['errorMessage' => $errorMessage]);
    }

    public function logout() {
        session::Stop();
        header('Location: ' . BASE_URL . '/');
        exit;
    }
}