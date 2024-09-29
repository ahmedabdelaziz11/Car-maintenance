<?php

namespace MVC\controllers;

use MVC\core\controller;
use MVC\core\session;
use MVC\models\offer;

class OfferManagementController extends controller{

    public function __construct()
    {
        if(!session::Get('user') && (session::Get('user')['role'] == 1 || session::Get('user')['role'] == 2) ){
            header('Location: ' . BASE_URL . '/user/login');
            exit;
        }
    }

    public function index()
    {
        $offer = new offer();
        $offers = $offer->getAllOffers();
        $this->view('offers/management', ['offers' => $offers]);
    }

    public function toggleStatus($id)
    {
        $offerModel = new Offer();
        echo $offer = $offerModel->getOfferByIdForAdmins($id);

        if ($offer) {
            $newStatus = $offer['is_active'] ? 0 : 1;
            $offerModel->updateRow(['id' => $id ,'is_active' => $newStatus]); 
        }

        header('Location: ' . BASE_URL . '/OfferManagement');
        exit();
    }
}