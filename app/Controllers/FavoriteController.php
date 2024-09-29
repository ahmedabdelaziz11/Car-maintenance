<?php


namespace MVC\controllers;

use MVC\core\controller;
use MVC\core\session;
use MVC\models\offer;

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
        $offers = $offerModel->favoriteOffers();
        $this->view('favorite', [
            'offers' => $offers,
        ]);
    }
}