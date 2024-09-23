<?php

namespace MVC\controllers;

use MVC\core\controller;
use MVC\models\service;

class ServiceController extends controller{

    public function index()
    {
        $serviceModel = new Service();
        $services = $serviceModel->getAll();
        $this->view('services/index', ['services' => $services]);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'image' => $_FILES['image']['name'],
            ];
            move_uploaded_file($_FILES['image']['tmp_name'], APP.'uploads/services/' . $data['image']);

            $serviceModel = new Service();
            $serviceModel->create($data);
            header('Location: /cars/public/service');
            exit;
        }

        $this->view('services/create', []);
    }

    public function edit($id)
    {
        $serviceModel = new Service();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'id' => $id,
                'name' => $_POST['name'],
                'image' => $_FILES['image']['name'],
            ];
            move_uploaded_file($_FILES['image']['tmp_name'], APP.'uploads/services/' . $data['image']);

            $serviceModel->updateRow($data);
            header('Location: /cars/public/service');
            exit;
        }

        $service = $serviceModel->getById($id);
        $this->view('services/edit', ['service' => $service]);
    }

    public function delete($id)
    {
        $serviceModel = new Service();
        $serviceModel->deleteRow($id);
        header('Location: /cars/public/service');
        exit;
    }

}