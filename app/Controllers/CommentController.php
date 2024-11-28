<?php

namespace MVC\controllers;

use MVC\core\controller;
use MVC\core\session;
use MVC\models\notification;
use MVC\models\offer;
use MVC\models\offerComment;

class CommentController extends controller{

    public function __construct()
    {
        if(!session::Get('user'))
        {
            header('Location: ' . BASE_URL . '/user/login');
            exit;
        }
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $comment = $data['comment'] ?? '';
            $offer_id = $data['offer_id'] ?? null;
    
            if (!empty($comment) && $offer_id && isset($_SESSION['user'])) {
                $offerCommentModel = new offerComment();
                $offerModel = new offer();
                $offer = $offerModel->getById($offer_id);
    
                $offerCommentModel->create([
                    'offer_id' => $offer_id,
                    'user_id' => $_SESSION['user']['id'],
                    'date' => date('Y-m-d H:i:s'),
                    'comment' => $comment,
                ]);
    
                $notificationModel = new notification();
                $notificationModel->create([
                    'offer_id' => $offer_id,
                    'user_id' => $offer['user_id'],
                    'date' => date('Y-m-d H:i:s'),
                    'message' => 'تم اضافة تعليق على عرضك من قبل ' . $_SESSION['user']['name'],
                ]);
    
                echo json_encode([
                    'success' => true,
                    'user_name' => $_SESSION['user']['name'],
                    'comment' => $comment,
                    'date' => date('F d, Y h:i A')
                ]);
                return;
            }
        }
    
        echo json_encode(['success' => false]);
        return;
    }

    public function delete($id)
    {
        $offerCommentModel = new offerComment();
        $comment = $offerCommentModel->getById($id);
        if ($comment && $comment['user_id'] == $_SESSION['user']['id']) {
            $offerCommentModel->deleteRow($id);
        }
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
}