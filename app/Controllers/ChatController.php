<?php

namespace MVC\controllers;

use MVC\core\controller;
use MVC\core\session;
use MVC\models\chat;
use MVC\models\user;

class ChatController extends controller{

    public function __construct()
    {
        if(!session::Get('user'))
        {
            header('Location: ' . BASE_URL . '/user/login');
            exit;
        }
    }

    public function index($user_id = null)
    {
        $chatModel = new chat();
        $userModel = new user();
        $usersIHaveChatWith = $chatModel->getChatUsers();
        $messages  = null;
        $receiver  = null;
        if($user_id)
        {
            $messages  = $chatModel->getChat($user_id);
            $receiver  = $userModel->getById($user_id);
            if($receiver)
            {
                return $this->view('chats/show', ['messages' => $messages, 'receiver' => $receiver,'usersIHaveChatWith' => $usersIHaveChatWith]);
            }
        }
        return $this->view('chats/index', ['messages' => $messages, 'receiver' => $receiver,'usersIHaveChatWith' => $usersIHaveChatWith]);
    }

    public function getMessages($user_id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $chatModel = new chat();
            $messages = $chatModel->getChat($user_id);

            header('Content-Type: application/json');
            echo json_encode(['status' => 'success', 'messages' => $messages]);
            exit;
        }
    }

    public function send($receiver_id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $message = $_POST['message'];
            $sender_id = session::get('user')['id'];

            if (!empty($message)) {
                $chatModel = new chat();
                $chatModel->create([
                    'sender_id' => $sender_id,
                    'receiver_id' => $receiver_id,
                    'message' => $message,
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                $response = [
                    'status' => 'success',
                    'message' => $message,
                    'sender_id' => $sender_id,
                    'receiver_id' => $receiver_id,
                    'created_at' => date('F d, Y h:i A')
                ];

                header('Content-Type: application/json');
                echo json_encode($response);
                exit;
            }

            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'Message cannot be empty.']);
            exit;
        }
    }
}