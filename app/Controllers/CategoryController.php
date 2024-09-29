<?php

namespace MVC\controllers;

use MVC\Traits\ImageUploaderTrait;
use MVC\core\controller;
use MVC\core\session;
use MVC\models\carType;
use MVC\models\category;

class CategoryController extends controller{
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
            die('ليس مسموح لك');
        }
    }
    
    public function index()
    {
        $category = new category();
        $categories = $category->getAll();
        $this->view('categories/index', ['categories' => $categories]);
    }

    public function create()
    {
        $carTypes = (new carType())->getAll();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validateCreateRequest();
            if (empty($errors)) {
                $uploadedImage = $this->uploadImage($_FILES['image'], ROOT . 'public/uploads/categories/');

                if ($uploadedImage) {
                    $data = [
                        'name' => $_POST['name'],
                        'car_type_id' => $_POST['car_type_id'],
                        'image' => $uploadedImage,
                    ];

                    $category = new category();
                    $category->create($data);

                    header('Location: ' . BASE_URL . '/category');
                    exit;
                } else {
                    $errors[] = 'فشل تحميل الصورة.';
                }
            } else {
                $errorMessage = implode("<br>", $errors);
                $this->view('categories/create', ['errorMessage' => $errorMessage,'carTypes' => $carTypes]);
            }
        }

        $this->view('categories/create', ['carTypes' => $carTypes]);
    }

    public function edit($id)
    {
        $categoryModel = new category();
        $carTypes = (new carType())->getAll();

        $category = $categoryModel->getById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validateEditRequest($id);
            if (empty($errors)) {
                $data = [
                    'id' => $id,
                    'name' => $_POST['name'],
                    'car_type_id' => $_POST['car_type_id'],
                ];
                if (!empty($_FILES['image']['name'])) {
                    $uploadedImage = $this->uploadImage($_FILES['image'], ROOT . 'public/uploads/categories/');
                    $data['image'] = $uploadedImage;
                    $oldImagePath = ROOT . 'public/uploads/categories/' . $category['image'];
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                $categoryModel->updateRow($data);
                header('Location: ' . BASE_URL . '/category');
                exit;
            } else {
                $errorMessage = implode("<br>", $errors);
                $this->view('categories/edit', ['errorMessage' => $errorMessage,'category' => $category,'carType' => $carTypes]);
            }
        }
        $this->view('categories/edit', ['category' => $category,'carTypes' => $carTypes]);
    }

    public function delete($id)
    {
        $categoryModel = new category();
        $category = $categoryModel->getById($id);
        $oldImagePath = ROOT . 'public/uploads/categories/' . $category['image'];
        if (file_exists($oldImagePath)) {
            unlink($oldImagePath);
        }
        $categoryModel->deleteRow($id);
        header('Location: ' . BASE_URL . '/category');
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

        if (empty($_POST['car_type_id'])) {
            $errors[] = 'نوع السيارة مطلوب';
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

        if (empty($_POST['car_type_id'])) {
            $errors[] = 'نوع السيارة مطلوب';
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
        $categoryModel = new category();
        return  $categoryModel->getByName($name,$id);
    }
}