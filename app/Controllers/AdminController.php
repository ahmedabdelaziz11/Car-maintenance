<?php

namespace MVC\controllers;

use MVC\core\controller;
use MVC\core\session;
use MVC\models\user;

class AdminController extends controller{

    public function __construct()
    {
        $user = session::Get('user');
        if(!$user)
        {
            header('Location: ' . BASE_URL . '/user/login');
            exit;
        }
        if($user['role'] != 1)
        {
            die('ليس مسموح لك');
        }
    }
    
    public function index()
    {
        $user = new user();
        $admins = $user->GetAllAdmins();
        $this->view('admins/index', ['admins' => $admins]);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validateCreateRequest();
            if (empty($errors)) {
                $data = [
                    'name' => $_POST['name'],
                    'email' => $_POST['email'],
                    'role' => $_POST['role'],
                    'password' => password_hash($_POST['password'], PASSWORD_BCRYPT)
                ];
                $user = new user();
                $user->create($data);
            } else {
                $errorMessage = implode("<br>", $errors);
                $this->view('admins/create', ['errorMessage' => $errorMessage]);
            }
        }

        $this->view('admins/create', []);
    }

    public function edit($id)
    {
        $userModel = new user();
        $admin = $userModel->getById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validateEditRequest($id);
            if (empty($errors)) {
                $data = [
                    'id' => $id,
                    'name' => $_POST['name'],
                    'email' => $_POST['email'],
                    'role' => $_POST['role'],
                ];
                if (!empty($_POST['password'])) {
                    $data['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
                }
                $userModel->updateRow($data);
                header('Location: ' . BASE_URL . '/admin');
                exit;
            } else {
                $errorMessage = implode("<br>", $errors);
                $this->view('admins/edit', ['errorMessage' => $errorMessage,'admin' => $admin]);
            }
        }
        $this->view('admins/edit', ['admin' => $admin]);
    }

    public function delete($id)
    {
        $userModel = new User();
        $userModel->deleteRow($id);
        header('Location: ' . BASE_URL . '/admin');
        exit;
    }

    public function validateCreateRequest()
    {
        $errors = [];
        if (empty($_POST['name'])) {
            $errors[] = 'اسم المسؤول مطلوب';
        }

        if (empty($_POST['email'])) {
            $errors[] = 'البريد الالكتروني مطلوب';
        } else {
            if ($this->isEmailExists($_POST['email'])) {
                $errors[] = 'البريد الالكتروني مستخدم بالفعل';
            }
        }

        if (empty($_POST['password'])) {
            $errors[] = 'الرقم السري مطلوب';
        }

        if (empty($_POST['role'])) {
            $errors[] = 'نوع المسوؤل مطلوب';
        }

        return  $errors;
    }

    public function validateEditRequest($id) {
        $errors = [];
        if (empty($_POST['name'])) {
            $errors[] = 'اسم المسؤول مطلوب';
        }

        if (empty($_POST['email'])) {
            $errors[] = 'البريد الالكتروني مطلوب';
        } else {
            if ($this->isEmailExists($_POST['email'], $id)) {
                $errors[] = 'البريد الالكتروني مستخدم بالفعل';
            }
        }

        return $errors;
    }

    public function isEmailExists($email,$id = null)
    {
        $userModel = new user();
        return  $userModel->getByEmail($email,$id);
    }
}