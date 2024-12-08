<?php


namespace MVC\controllers;

use MVC\core\controller;
use MVC\core\session;
use MVC\models\follow;
use MVC\models\offer;
use MVC\models\userFollow;

class FavoriteController extends controller{

    public function __construct()
    {
        if(!session::Get('user'))
        {
            header('Location: ' . BASE_URL . '/user/login');
            exit;
        }
    }
    
    public function index()
    {
        $offerModel = new offer();
        $userFollowerModel = new userFollow();
        $followModel = new follow();
        $offers = $offerModel->favoriteOffers();
        $users  = $userFollowerModel->getFollowing();
        $services = $followModel->getFollows();
        $this->view('favorite', [
            'offers' => $offers,
            'users' => $users,
            'services' => $services,
        ]);
    }

    public function deleteFollow()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents("php://input"), true);
            $followModel = new follow();

            $followModel->deleteRow($input['follow_id']);

            echo json_encode(['success' => true]);
            exit;
        }
    }
}