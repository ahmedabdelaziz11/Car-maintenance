<?php


namespace MVC\controllers;

use MVC\core\controller;
use MVC\core\session;
use MVC\models\category;
use MVC\models\follow;
use MVC\models\offer;
use MVC\models\service;

class HomeController extends controller{

    public function index()
    {
        $offerModel = new offer();
        $serviceModel = new service();
        $categoryModel = new category(); 
        $followModel = new follow(); 
    
        $services = $serviceModel->getAll(); 
        $categories = $categoryModel->getAll(); 
    
        $service_id = $_GET['service_id'] ?? null;
        $category_id = $_GET['category_id'] ?? null;
        $model_from = $_GET['model_from'] ?? null;
        $model_to = $_GET['model_to'] ?? null;
        $page = $_GET['page'] ?? 1;
    
        $offers = $offerModel->getAllWithPaginated($service_id, $category_id, $model_from, $model_to, $page);

        if (isset($_GET['action'])) {
            $action = $_GET['action'];
            if ($action == 'follow' 
                && session::Get('user') 
                && isset($_GET['service_id']) && $_GET['service_id'] != null
                && isset($_GET['category_id']) && $_GET['category_id'] != null
            ) {
                if(!$followModel->followExist($_GET['service_id'],$_GET['category_id'],session::Get('user')['id']))
                {
                    $followModel->create([
                        'user_id' =>  session::Get('user')['id'],
                        'service_id' => $_GET['service_id'],
                        'category_id' => $_GET['category_id'],
                    ]);
                }
            }
            $offers = $offerModel->getAllWithPaginated(null, null, null, null, $page);
        }
    
        $this->view('index', [
            'offers' => $offers,
            'services' => $services,
            'categories' => $categories,
            'page' => $page
        ]);
    }
    
}