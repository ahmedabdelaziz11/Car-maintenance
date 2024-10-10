<?php

namespace MVC\models;

use MVC\core\model;

class message extends model {
    public function __construct() {
        parent::__construct();
        $this->table = "messages";
    }

    public function addMessage($data) {
        return $this->insert($data)->execute();
    }

    public function getMessagesByContactId($contactId) {
        return $this->select()->where('contact_id', '=', $contactId)->orderBy('created_at', 'ASC')->all();
    }
}
