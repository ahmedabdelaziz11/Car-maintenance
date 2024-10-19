<?php

namespace MVC\controllers;

use MVC\core\controller;
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
        $offer = $offerModel->getById($id);
    
        $this->view('offers/show', [
            'offer' => $offer,
            'offerOwner' => $offer['user_id'],
        ]);
    } 
}











