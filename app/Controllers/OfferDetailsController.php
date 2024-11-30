<?php

namespace MVC\controllers;

use MVC\core\controller;
use MVC\models\category;
use MVC\models\notification;
use MVC\models\offer;

class OfferDetailsController extends controller{

    public function show($id,$notification_id = null)
    {
        if($notification_id){
            $notificationModel = new notification();
            $notificationModel->updateRow(['id' => $notification_id,'is_read' => 1]);
        }
        $offerModel = new offer();
        $check = $offerModel->checkIfExist($id);
        $offer = $offerModel->getById($id);
        if($check)
        {
            $this->view('offers/show', [
                'offer' => $offer,
                'offerOwner' => $offer['user_id'],
            ]);
        }
        $this->view('404', []);
    } 

    public function getCategoriesByCarType($carTypeId)
    {
        $categoryModel = new category();
        $categories = $categoryModel->categoryByCarTypeId($carTypeId);

        echo json_encode($categories);
    }
}











