<?php

namespace MVC\controllers;

use MVC\Traits\ImageUploaderTrait;
use MVC\core\controller;
use MVC\core\Session;
use MVC\models\category;

class CategoryController extends controller{
    use ImageUploaderTrait;

    public function __construct()
    {
        $user = Session::Get('user');
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validateCreateRequest();
            if (empty($errors)) {
                $uploadedImage = $this->uploadImage($_FILES['image'], ROOT . 'public/uploads/categories/');

                if ($uploadedImage) {
                    $data = [
                        'name' => $_POST['name'],
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
                $this->view('categories/create', ['errorMessage' => $errorMessage]);
            }
        }

        $this->view('categories/create', []);
    }

    public function edit($id)
    {
        $categoryModel = new category();
        $category = $categoryModel->getById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validateEditRequest($id);
            if (empty($errors)) {
                $data = [
                    'id' => $id,
                    'name' => $_POST['name'],
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
                $this->view('categories/edit', ['errorMessage' => $errorMessage,'category' => $category]);
            }
        }
        $this->view('categories/edit', ['category' => $category]);
    }

    public function delete($id)
    {
        $categoryModel = new Category();
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
        $categoryModel = new category();
        return  $categoryModel->getByName($name,$id);
    }
}