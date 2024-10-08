<?php

namespace MVC\controllers;

use MVC\core\controller;
use MVC\core\session;
use MVC\models\report;


class ReportController extends controller{

    public function __construct()
    {
        if(!session::Get('user'))
        {
            header('Location: ' . BASE_URL . '/user/login');
            exit;
        }
    }

    public function index() {
        if(!session::Get('user')  || !session::Get('user')['role'] == 3)
        {
            header('Location: ' . BASE_URL . '/user/login');
            exit;
        }
        $reportModel = new report();
        $reports = $reportModel->getAllReports();

        $this->view('reports/index', [
            'reports' => $reports
        ]);
    }

    public function store()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($_SESSION['user'])) {
            echo json_encode(['success' => false, 'message' => 'User not logged in.']);
            return;
        }

        $user_id = $_SESSION['user']['id'];
        $description = $data['description'] ?? null;
        $offer_id = $data['offer_id'] ?? null;
        $comment_id = $data['comment_id'] ?? null;

        if (empty($description)) {
            echo json_encode(['success' => false, 'message' => 'Description is required.']);
            return;
        }

        $reportData = [
            'user_id' => $user_id,
            'description' => $description
        ];

        $reportModel = new report();
        if ($offer_id) {
            $reportData['offer_id'] = $offer_id;

            $result = $reportModel->create($reportData);
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Offer report submitted successfully.']);
            }else{
                echo json_encode(['success' => false, 'message' => 'Failed to submit offer report,you are reported it  before.']);
            }
        } elseif ($comment_id) {
            $reportData['comment_id'] = $comment_id;

            $result = $reportModel->create($reportData);
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'comment report submitted successfully.']);
            }else{
                echo json_encode(['success' => false, 'message' => 'Failed to submit comment report,you are reported it  before.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid report data.']);
        }
    }
}