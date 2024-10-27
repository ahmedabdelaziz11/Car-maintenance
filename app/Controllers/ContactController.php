<?php

namespace MVC\controllers;

use MVC\core\controller;
use MVC\core\session;
use MVC\models\contact;
use MVC\models\message;
use MVC\models\user;

class ContactController extends controller {

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
        $contact = new contact();
        $messageModel = new message();

        $userId = session::Get('user')['id'];
        $userRole = session::Get('user')['role'];
        if($userRole == 3)
        {
            $conversations = $contact->getContactsByUser($userId);

            foreach ($conversations as &$conversation) {
                $conversation['unread_count'] = $messageModel->countUnreadMessagesByContactId($conversation['id'])['count'];
            }
            
            $this->view('contacts/index', ['conversations' => $conversations]);
        }
        $userModel = new user();
        $allowedTypes = $userModel->getAllowedContactTypes($userId);
        if (!empty($allowedTypes)) {
            $contact = new contact();
            $conversations = $contact->getConversationsByTypes($allowedTypes);
            foreach ($conversations as &$conversation) {
                $conversation['unread_count'] = $messageModel->countUnreadMessagesByContactIdForAdmin($conversation['id'])['count'];
            }

            $this->view('contacts/index', ['conversations' => $conversations]);
        } else {
            $this->view('contacts/index', ['conversations' => []]);
        }

    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'user_id'      => session::Get('user')['id'],
                'contact_type' => $_POST['contact_type'],
                'message'      => $_POST['title'],
                'status'       => 0,
                'created_at'   => date('Y-m-d H:i:s'),
            ];

            $contact = new contact();
            $contactId = $contact->createContact($data);

            $data = [
                'contact_id' => $contactId,
                'sender' => session::Get('user')['role'] == 1 ? 'admin' : 'user',
                'message' => $_POST['message'],
                'created_at'   => date('Y-m-d H:i:s'),
            ];

            $message = new message();
            $message->addMessage($data);
            
            header('Location: ' . BASE_URL . '/contact/show/' . $contactId);
            exit;
        }

        $this->view('contacts/create', []);
    }

    public function show($id) {
        $contact = new contact();
        $messageModel = new message();

        $contactDetails = $contact->getContactById($id);
        $messages = $messageModel->getMessagesByContactId($id);

        $userRole = session::Get('user')['role'];
        if ($userRole == 3) {
            $messageModel->markMessagesAsRead($id);
        }else{
            $messageModel->markMessagesAsReadForAdmin($id);
        }

        $this->view('contacts/view', [
            'contact' => $contactDetails,
            'messages' => $messages
        ]);
    }

    public function addMessage($contactId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'contact_id' => $contactId,
                'sender' => session::Get('user')['role'] == 1 ? 'admin' : 'user',
                'message' => $_POST['message'],
                'created_at'   => date('Y-m-d H:i:s'),
            ];

            $message = new message();
            $message->addMessage($data);

            header('Location: ' . BASE_URL . '/contact/show/' . $contactId);
            exit;
        }
    }
}
