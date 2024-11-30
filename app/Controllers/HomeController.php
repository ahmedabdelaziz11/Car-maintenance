<?php


namespace MVC\controllers;

use MVC\core\controller;
use MVC\core\session;
use MVC\models\carType;
use MVC\models\country;
use MVC\models\follow;
use MVC\models\offer;
use MVC\models\service;

class HomeController extends controller{

    public function index()
    {
        $offerModel = new offer();
        $serviceModel = new service();
        $carTypeModel = new carType();
        $followModel = new follow();
        $countryModel = new country();
        
        $services = $serviceModel->getAll();
        $carTypes = $carTypeModel->getAll();
        $countries = $countryModel->getAll();
        
        $service_id  = $_GET['service_id'] ?? null;
        $car_type_id = $_GET['car_type_id'] ?? null;
        $category_id = $_GET['category_id'] ?? null;
        $model_from  = $_GET['model_from'] ?? null;
        $country_id  = $_GET['country_id'] ?? null;
        $page        = $_GET['page'] ?? 1;
    
        if (isset($_GET['action']) && in_array($_GET['action'], ['follow', 'unfollow'])) {
            if (session::Get('user') && $service_id && $category_id) {
                $user_id = session::Get('user')['id'];
                
                if ($_GET['action'] === 'follow') {
                    if (!$followModel->followExist($service_id, $category_id, $user_id)) {
                        $followModel->create([
                            'user_id' => $user_id,
                            'service_id' => $service_id,
                            'category_id' => $category_id,
                        ]);
                        echo json_encode(['success' => true, 'message' => 'You are now following this service.']);
                        return;
                    }
                } elseif ($_GET['action'] === 'unfollow') {
                    $row = $followModel->followExist($service_id, $category_id, $user_id);
                    if ($row) {
                        $followModel->deleteRow($row['id']);
                        echo json_encode(['success' => true, 'message' => 'You have unfollowed this service.']);
                        return;
                    }
                }
            }
            echo json_encode(['success' => false, 'message' => 'Action failed.']);
            return;
        }
        
        $is_follow = session::Get('user') ? $followModel->followExist($service_id, $category_id, session::Get('user')['id']) : 0;
    
        $offersData = $offerModel->getAllWithPaginated($service_id, $car_type_id, $category_id, $model_from,$country_id, $page);
    
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            echo $this->view('partials/offers', [
                'offers' => $offersData['offers'],
                'is_follow' => $is_follow,
                'page' => $page,
                'hasNextPage' => $offersData['hasNextPage'],
                'totalPages' => $offersData['totalPages']
            ]);
            return;
        } else {
            $this->view('index', [
                'offers' => $offersData['offers'],
                'is_follow' => $is_follow,
                'services'  => $services,
                'carTypes'  => $carTypes,
                'countries' => $countries,
                'page' => $page,
                'hasNextPage' => $offersData['hasNextPage'],
                'totalPages' => $offersData['totalPages']
            ]);
        }
    }    
    
    public function changLang($lang)
    {
        if(in_array($lang,['ar','en']))
        {
            $_SESSION['lang'] = $lang;
        }
        $response = ['success' => true];
        echo json_encode($response);
    }
}