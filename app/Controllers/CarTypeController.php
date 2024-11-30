<?php

namespace MVC\controllers;

use MVC\Traits\ImageUploaderTrait;
use MVC\core\controller;
use MVC\core\session;
use MVC\models\carType;
use MVC\models\category;

class CarTypeController extends controller{
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
        $carType = new carType();
        $carTypes = $carType->getAll();
        $this->view('carTypes/index', ['carTypes' => $carTypes]);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validateCreateRequest();
            if (empty($errors)) {
                $uploadedImage = $this->uploadImage($_FILES['image'], ROOT . 'public/uploads/car_types/');

                if ($uploadedImage) {
                    $data = [
                        'name' => $_POST['name'],
                        'image' => $uploadedImage,
                    ];

                    $carType = new carType();
                    $carType->create($data);

                    header('Location: ' . BASE_URL . '/carType');
                    exit;
                } else {
                    $errors[] = 'فشل تحميل الصورة.';
                }
            } else {
                $errorMessage = implode("<br>", $errors);
                $this->view('carTypes/create', ['errorMessage' => $errorMessage]);
            }
        }

        $this->view('carTypes/create', []);
    }

    public function edit($id)
    {
        $carTypeModel = new carType();
        $carType = $carTypeModel->getById($id);
        if ($carType) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $errors = $this->validateEditRequest($id);
                if (empty($errors)) {
                    $data = [
                        'id' => $id,
                        'name' => $_POST['name'],
                    ];
                    if (!empty($_FILES['image']['name'])) {
                        $uploadedImage = $this->uploadImage($_FILES['image'], ROOT . 'public/uploads/car_types/');
                        $data['image'] = $uploadedImage;
                        $oldImagePath = ROOT . 'public/uploads/car_types/' . $carType['image'];
                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }
                    $carTypeModel->updateRow($data);
                    header('Location: ' . BASE_URL . '/carType');
                    exit;
                } else {
                    $errorMessage = implode("<br>", $errors);
                    $this->view('carTypes/edit', ['errorMessage' => $errorMessage,'carType' => $carType]);
                }
            }
            $this->view('carTypes/edit', ['carType' => $carType]);
        }
        header('Location: ' . BASE_URL . '/carType');
    }

    public function delete($id)
    {
        $carTypeModel = new carType();
        $carType = $carTypeModel->getById($id);
        if($carType)
        {
            $categoryModel = new category();
            if(count($categoryModel->categoryByCarTypeId($id)) >  0){
                $errorMessage = "يجب حذف فئات السيارة اولا";
                $this->view('carTypes/index', ['errorMessage' => $errorMessage,'carTypes' => $carTypeModel->getAll()]);
                exit;
            }
            $oldImagePath = ROOT . 'public/uploads/car_types/' . $carType['image'];
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
            $carTypeModel->deleteRow($id);
        }
        header('Location: ' . BASE_URL . '/carType');
        exit;
    }

    public function validateCreateRequest()
    {
        $errors = [];
        if (empty($_POST['name'])) {
            $errors[] = 'اسم الفئة مطلوب';
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
            $errors[] = 'اسم الفئة مطلوب';
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
        $carTypeModel = new carType();
        return  $carTypeModel->getByName($name,$id);
    }
}