<?php

namespace MVC\controllers;

use MVC\core\controller;
use MVC\core\session;
use MVC\models\city;
use MVC\models\country;

class CityController extends controller{

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
        $city = new city();
        $cities = $city->getAll();
        $this->view('cities/index', ['cities' => $cities]);
    }

    public function create()
    {
        $countries = (new country())->getAll();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validateCreateRequest();
            if (empty($errors)) {
                $data = [
                    'name' => $_POST['name'],
                    'country_id' => $_POST['country_id'],
                ];
                $city = new city();
                $city->create($data);

                header('Location: ' . BASE_URL . '/city');
                    exit;
            } else {
                $errorMessage = implode("<br>", $errors);
                $this->view('cities/create', ['errorMessage' => $errorMessage,'countries' => $countries]);
            }
        }

        $this->view('cities/create', ['countries' => $countries]);
    }

    public function edit($id)
    {
        $cityModel = new city();
        $countries = (new country())->getAll();

        $city = $cityModel->getById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validateEditRequest($id);
            if (empty($errors)) {
                $data = [
                    'id' => $id,
                    'name' => $_POST['name'],
                    'country_id' => $_POST['country_id'],
                ];
                $cityModel->updateRow($data);
                header('Location: ' . BASE_URL . '/city');
                exit;
            } else {
                $errorMessage = implode("<br>", $errors);
                $this->view('cities/edit', ['errorMessage' => $errorMessage,'city' => $city,'countries' => $countries]);
            }
        }
        $this->view('cities/edit', ['city' => $city,'countries' => $countries]);
    }

    public function delete($id)
    {
        $cityModel = new city();
        $cityModel->deleteRow($id);
        header('Location: ' . BASE_URL . '/city');
        exit;
    }

    public function validateCreateRequest()
    {
        $errors = [];
        if (empty($_POST['name'])) {
            $errors[] = 'اسم المدينة مطلوب';
        }else {
            if ($this->isNameExists($_POST['name'])) {
                $errors[] = 'الاسم مستخدم بالفعل';
            }
        }

        if (empty($_POST['country_id'])) {
            $errors[] = 'نوع البلد مطلوب';
        }

        return  $errors;
    }

    public function validateEditRequest($id) {
        $errors = [];
        if (empty($_POST['name'])) {
            $errors[] = 'اسم المدينة مطلوب';
        }else {
            if ($this->isNameExists($_POST['name'],$id)) {
                $errors[] = 'الاسم مستخدم بالفعل';
            }
        }

        if (empty($_POST['country_id'])) {
            $errors[] = 'نوع البلد مطلوب';
        }
        return $errors;
    }

    public function isNameExists($name,$id = null)
    {
        $cityModel = new city();
        return  $cityModel->getByName($name,$id);
    }
}