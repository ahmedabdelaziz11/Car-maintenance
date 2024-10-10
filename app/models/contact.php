<?php

namespace MVC\models;

use MVC\core\model;

class contact extends model {
    public function __construct() {
        parent::__construct();
        $this->table = "contacts";
    }

    public function createContact($data) {
        return $this->insert($data)->execute();
    }

    public function getContactsByUser($userId) {
        return $this->select()->where('user_id', '=', $userId)->all();
    }

    public function getAllConversations()
    {
        return $this->select(['id', 'user_id', 'contact_type', 'message', 'created_at'])
            ->orderBy('created_at', 'DESC')
            ->all();
    }

    public function getContactById($id) {
        return $this->select()->where('id', '=', $id)->row();
    }
}