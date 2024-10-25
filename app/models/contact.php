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
        return $this->select([
            'contacts.*', 
            'users.name AS user_name', 
        ])
        ->join('users', 'contacts.user_id = users.id')
        ->where('user_id', '=', $userId)
        ->all();
    }

    public function getContactById($id) {
        return $this->select([
            'contacts.*', 
            'users.name AS user_name', 
        ])
        ->join('users', 'contacts.user_id = users.id')
        ->where('contacts.id', '=', $id)
        ->row();
    }

    public function getConversationsByTypes($contactTypes) {
        if (empty($contactTypes)) {
            return [];
        }
        return $this->select([
                'contacts.*', 
                'users.name AS user_name', 
            ])
            ->join('users', 'contacts.user_id = users.id')
            ->whereIn('contact_type',$contactTypes)
            ->orderBy('created_at', 'DESC')
            ->all();
    }
}