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
            header("HTTP/1.1 403 Forbidden");
            echo "You do not have permission to access this resource.";
            exit;
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
                    'phone' => $_POST['phone'],
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
        if ($admin) {
            $assignedTypes = $userModel->getAllowedContactTypes($id);
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $errors = $this->validateEditRequest($id);
                if (empty($errors)) {
                    $contactTypes = $_POST['contact_types'] ?? [];

                    $jsonContactTypes = json_encode($contactTypes);
                    $data = [
                        'id' => $id,
                        'name' => $_POST['name'],
                        'email' => $_POST['email'],
                        'phone' => $_POST['phone'],
                        'role' => $_POST['role'],
                        'contact_types' => $jsonContactTypes
                    ];

                    if (!empty($_POST['password'])) {
                        $data['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
                    }
                    $userModel->updateRow($data);
                    header('Location: ' . BASE_URL . '/admin');
                    exit;
                } else {
                    $errorMessage = implode("<br>", $errors);
                    $this->view('admins/edit', ['errorMessage' => $errorMessage,'admin' => $admin,'assignedTypes' => $assignedTypes]);
                }
            }
            $this->view('admins/edit', ['admin' => $admin,'assignedTypes' => $assignedTypes]);
        }
        header('Location: ' . BASE_URL . '/admin');
        exit;
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
        $userModel = new user();

        if (empty($_POST['name'])) {
            $errors[] = 'اسم المسؤول مطلوب';
        }else{
            if ($userModel->getByUsername($_POST['name']) != null) {
                $errors['username'] = __("Username is already taken.");
            }
            if (strlen($_POST['name']) < 3) {
                $errors['username'] = __('Username must be at least 3 characters long.');
            }
            if (strlen($_POST['name']) > 20) {
                $errors['username'] = __('Username cannot exceed 20 characters.');
            }
        }

        if (empty($_POST['email'])) {
            $errors[] = 'البريد الالكتروني مطلوب';
        } else {
            if ($this->isEmailExists($_POST['email'])) {
                $errors[] = 'البريد الالكتروني مستخدم بالفعل';
            }
        }

        $phone = $_POST['phone'] ?? '';
        if (empty($phone)) {
            $errors['phone'] = __("Phone number is required.");
        } elseif ($userModel->getByPhone($phone) != null) {
            $errors['phone'] = __("Phone number is already taken.");
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
        $userModel = new user();

        if (empty($_POST['name'])) {
            $errors[] = 'اسم المسؤول مطلوب';
        }else{
            if ($userModel->getByUsername($_POST['name']) != null) {
                $errors['username'] = __("Username is already taken.");
            }
            if (strlen($_POST['name']) < 3) {
                $errors['username'] = __('Username must be at least 3 characters long.');
            }
            if (strlen($_POST['name']) > 20) {
                $errors['username'] = __('Username cannot exceed 20 characters.');
            }
        }

        if (empty($_POST['email'])) {
            $errors[] = 'البريد الالكتروني مطلوب';
        } else {
            if ($this->isEmailExists($_POST['email'], $id)) {
                $errors[] = 'البريد الالكتروني مستخدم بالفعل';
            }
        }

        $phone = $_POST['phone'] ?? '';
        if (empty($phone)) {
            $errors['phone'] = __("Phone number is required.");
        } elseif ($userModel->getByPhone($phone) != null) {
            $errors['phone'] = __("Phone number is already taken.");
        }

        return $errors;
    }

    public function isEmailExists($email,$id = null)
    {
        $userModel = new user();
        return  $userModel->getByEmail($email,$id);
    }

    public function dashboard()
    {
        $user = new user();
        $data = $user->GetAdminDashboardData();
        $this->view('admins/dashboard', ['data' => $data]);
    }
}