<?php

namespace MVC\controllers;

use MVC\Traits\ImageUploaderTrait;
use MVC\core\controller;
use MVC\core\session;
use MVC\models\service;

class ServiceController extends controller{
    use ImageUploaderTrait;

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
        $serviceModel = new Service();
        $services = $serviceModel->getAll();
        $this->view('services/index', ['services' => $services]);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validateCreateRequest();
            if (empty($errors)) {
                $uploadedImage = $this->uploadImage($_FILES['image'], ROOT . 'public/uploads/services/');

                if ($uploadedImage) {
                    $data = [
                        'name' => $_POST['name'],
                        'image' => $uploadedImage,
                    ];

                    $serviceModel = new Service();
                    $serviceModel->create($data);

                    header('Location: ' . BASE_URL . '/service');
                    exit;
                } else {
                    $errors[] = 'فشل تحميل الصورة.';
                }
            } else {
                $errorMessage = implode("<br>", $errors);
                $this->view('services/create', ['errorMessage' => $errorMessage]);
            }
        }

        $this->view('services/create', []);
    }

    public function edit($id)
    {
        $serviceModel = new Service();
        $service = $serviceModel->getById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validateEditRequest($id);
            if (empty($errors)) {
                $data = [
                    'id' => $id,
                    'name' => $_POST['name'],
                ];
                if (!empty($_FILES['image']['name'])) {
                    $uploadedImage = $this->uploadImage($_FILES['image'], ROOT . 'public/uploads/services/');
                    $data['image'] = $uploadedImage;
                    $oldImagePath = ROOT . 'public/uploads/services/' . $service['image'];
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                $serviceModel->updateRow($data);
                header('Location: ' . BASE_URL . '/service');
                exit;
            } else {
                $errorMessage = implode("<br>", $errors);
                $this->view('services/edit', ['errorMessage' => $errorMessage,'service' => $service]);
            }
        }
        $this->view('services/edit', ['service' => $service]);
    }

    public function delete($id)
    {
        $serviceModel = new Service();
        $service = $serviceModel->getById($id);
        $oldImagePath = ROOT . 'public/uploads/services/' . $service['image'];
        if (file_exists($oldImagePath)) {
            unlink($oldImagePath);
        }
        $serviceModel->deleteRow($id);
        header('Location: ' . BASE_URL . '/service');
        exit;
    }

    public function validateCreateRequest()
    {
        $errors = [];
        if (empty($_POST['name'])) {
            $errors[] = 'اسم الخدمة مطلوب';
        }else {
            if ($this->isNameExists($_POST['name'])) {
                $errors[] = 'الاسم مستخدم بالفعل';
            }
        }

        $imageErrors = $this->validateImage($_FILES['image']);
        if (!empty($imageErrors)) {
            $errors = array_merge($errors, $imageErrors);
        }
        return  $errors;
    }

    public function validateEditRequest($id) {
        $errors = [];
        if (empty($_POST['name'])) {
            $errors[] = 'اسم الخدمة مطلوب';
        }else {
            if ($this->isNameExists($_POST['name'],$id)) {
                $errors[] = 'الاسم مستخدم بالفعل';
            }
        }
        if (!empty($_FILES['image']['name'])) {
            $imageErrors = $this->validateImage($_FILES['image']);
            if (!empty($imageErrors)) {
                $errors = array_merge($errors, $imageErrors);
            }
        }
        return $errors;
    }

    public function isNameExists($name,$id = null)
    {
        $serviceModel = new service();
        return  $serviceModel->getByName($name,$id);
    }
}