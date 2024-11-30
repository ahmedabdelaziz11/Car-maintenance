<?php

namespace MVC\controllers;

use MVC\core\controller;
use MVC\core\session;
use MVC\models\country;
use MVC\models\category;
use MVC\models\city;

class CountryController extends controller{

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
        $country = new country();
        $countries = $country->getAll();
        $this->view('countries/index', ['countries' => $countries]);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validateCreateRequest();
            if (empty($errors)) {
                $data = [
                    'name' => $_POST['name'],
                ];

                $country = new country();
                $country->create($data);

                header('Location: ' . BASE_URL . '/country');
                exit;
            } else {
                $errorMessage = implode("<br>", $errors);
                $this->view('countries/create', ['errorMessage' => $errorMessage]);
            }
        }

        $this->view('countries/create', []);
    }

    public function edit($id)
    {
        $countryModel = new country();
        $country = $countryModel->getById($id);
        if($country)
        {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $errors = $this->validateEditRequest($id);
                if (empty($errors)) {
                    $data = [
                        'id' => $id,
                        'name' => $_POST['name'],
                    ];
                    $countryModel->updateRow($data);
                    header('Location: ' . BASE_URL . '/country');
                    exit;
                } else {
                    $errorMessage = implode("<br>", $errors);
                    $this->view('countries/edit', ['errorMessage' => $errorMessage,'country' => $country]);
                }
            }
            $this->view('countries/edit', ['country' => $country]);
        }
        header('Location: ' . BASE_URL . '/country');
    }

    public function delete($id)
    {
        $countryModel = new country();
        $cityModel = new city();
        if(count($cityModel->cityByCountryId($id)) >  0){
            $errorMessage = "يجب حذف مدن البلد اولا";
            $this->view('countries/index', ['errorMessage' => $errorMessage,'countries' => $countryModel->getAll()]);
            exit;
        }
        $countryModel->deleteRow($id);
        header('Location: ' . BASE_URL . '/country');
        exit;
    }

    public function validateCreateRequest()
    {
        $errors = [];
        if (empty($_POST['name'])) {
            $errors[] = 'اسم البلد مطلوب';
        }else {
            if ($this->isNameExists($_POST['name'])) {
                $errors[] = 'الاسم مستخدم بالفعل';
            }
        }

        return  $errors;
    }

    public function validateEditRequest($id) {
        $errors = [];
        if (empty($_POST['name'])) {
            $errors[] = 'اسم البلد مطلوب';
        }else {
            if ($this->isNameExists($_POST['name'],$id)) {
                $errors[] = 'الاسم مستخدم بالفعل';
            }
        }
        return $errors;
    }

    public function isNameExists($name,$id = null)
    {
        $countryModel = new country();
        return  $countryModel->getByName($name,$id);
    }
}