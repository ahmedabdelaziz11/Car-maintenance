<?php


namespace MVC\controllers;

use MVC\core\controller;
use MVC\core\session;
use MVC\models\carType;
use MVC\models\country;
use MVC\models\follow;
use MVC\models\offer;
use MVC\models\service;
use MVC\models\user;

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

    public function verifyPhoneNumberView()
    {
        if(session::Get('user') && session::Get('user')['is_phone_verified'] == 0)
        {
            $this->view('verify-phone-number', []);
        }
        header('Location: ' . BASE_URL . '/');
    }

    public function verifyEmailView()
    {
        if(session::Get('user') && session::Get('user')['is_email_verified'] == 0)
        {
            $this->view('verify-email-number', []);
        }
        header('Location: ' . BASE_URL . '/');
    }

    public function verifyPhoneNumber()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode([
                'success' => false,
                'message' => __('Invalid request method.'),
            ]);
            exit;
        }
    
        $otp = trim($_POST['otp'] ?? '');
        if (empty($otp)) {
            echo json_encode([
                'success' => false,
                'message' => __('OTP is required.'),
            ]);
            exit;
        }
    
        $user = Session::Get('user');
        if (!$user || !isset($user['id'])) {
            echo json_encode([
                'success' => false,
                'message' => __('User is not authenticated.'),
            ]);
            exit;
        }
    
        $userModel = new user();
        $dbUser = $userModel->select(['id', 'otp', 'is_phone_verified'])
            ->where('id', '=', $user['id'])
            ->row();
    
        if (!$dbUser) {
            echo json_encode([
                'success' => false,
                'message' => __('User not found.'),
            ]);
            exit;
        }
    
        if ($dbUser['otp'] !== $otp) {
            echo json_encode([
                'success' => false,
                'message' => __('Invalid OTP. Please try again.'),
            ]);
            exit;
        }
    
        $updateStatus = $userModel->update([
            'is_phone_verified' => 1, 
            'otp'    => 0,
        ])->where('id', '=', $dbUser['id'])->execute();
        $_SESSION['user']['is_phone_verified'] = 1;
    
        if ($updateStatus) {
            echo json_encode([
                'success' => true,
                'message' => __('Phone number verified successfully!'),
                'redirectUrl' => BASE_URL . '/',
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => __('Failed to update user status. Please try again later.'),
            ]);
        }
    }   
    
    public function verifyEmail()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode([
                'success' => false,
                'message' => __('Invalid request method.'),
            ]);
            exit;
        }
    
        $otp = trim($_POST['otp'] ?? '');
        if (empty($otp)) {
            echo json_encode([
                'success' => false,
                'message' => __('OTP is required.'),
            ]);
            exit;
        }
    
        $user = Session::Get('user');
        if (!$user || !isset($user['id'])) {
            echo json_encode([
                'success' => false,
                'message' => __('User is not authenticated.'),
            ]);
            exit;
        }
    
        $userModel = new user();
        $dbUser = $userModel->select(['id', 'email_otp', 'is_email_verified'])
            ->where('id', '=', $user['id'])
            ->row();
    
        if (!$dbUser) {
            echo json_encode([
                'success' => false,
                'message' => __('User not found.'),
            ]);
            exit;
        }
    
        if ($dbUser['otp'] !== $otp) {
            echo json_encode([
                'success' => false,
                'message' => __('Invalid OTP. Please try again.'),
            ]);
            exit;
        }
    
        $updateStatus = $userModel->update([
            'is_email_verified' => 1, 
            'email_otp'    => 0,
        ])->where('id', '=', $dbUser['id'])->execute();
        $_SESSION['user']['is_email_verified'] = 1;
    
        if ($updateStatus) {
            echo json_encode([
                'success' => true,
                'message' => __('Email verified successfully!'),
                'redirectUrl' => BASE_URL . '/',
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => __('Failed to update user status. Please try again later.'),
            ]);
        }
    } 
}