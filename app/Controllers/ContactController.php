<?php

namespace MVC\controllers;

use MVC\core\controller;
use MVC\models\Contact;
use MVC\models\Message;
use MVC\core\session;

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
        $contact = new Contact();
        $conversations = $contact->getContactsByUser(session::Get('user')['id']);

        $this->view('contacts/index', ['conversations' => $conversations]);
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'user_id'      => session::Get('user')['id'],
                'contact_type' => $_POST['contact_type'],
                'message'      => $_POST['message'],
                'created_at'   => date('Y-m-d H:i:s'),
            ];

            $contact = new Contact();
            $contactId = $contact->createContact($data);
            
            header('Location: ' . BASE_URL . '/contact/show/' . $contactId);
            exit;
        }

        $this->view('contacts/create', []);
    }

    public function show($id) {
        $contact = new Contact();
        $messageModel = new Message();

        $contactDetails = $contact->getContactById($id);
        $messages = $messageModel->getMessagesByContactId($id);

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

            $message = new Message();
            $message->addMessage($data);

            header('Location: ' . BASE_URL . '/contact/show/' . $contactId);
            exit;
        }
    }
}
