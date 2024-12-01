<?php


namespace MVC\controllers;

use MVC\core\controller;
use MVC\core\session;
use MVC\models\offer;
use MVC\models\user;
use MVC\models\userFollow;

class UserController extends controller{
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
                $authenticatedUser = $user->select(['id','name', 'email', 'password', 'role'])
                    ->where('email', '=', $email)
                    ->row();
    
                if ($authenticatedUser && password_verify($password, $authenticatedUser['password'])) {
                    session::Set('user', [
                        'id' => $authenticatedUser['id'],
                        'name' => $authenticatedUser['name'],
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

    public function follow()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents("php://input"), true);
            $followModel = new userFollow();

            $followModel->create([
                'follower_id' => $input['follower_id'],
                'following_id' => $input['following_id']
            ]);

            echo json_encode(['success' => true]);
            exit;
        }
    }

    public function profile($userId)
    {
        $userModel = new user();
        $offerModel = new offer();

        $user = $userModel->getById($userId);
        if(!$user)
        {
            $this->view('404', []);
        }
        $offers = $offerModel->getOffersByUserId($userId);

        $this->view('users/profile', [
            'user' => $user,
            'offers' => $offers
        ]);
    }
}