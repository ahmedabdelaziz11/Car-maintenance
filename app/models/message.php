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

    public function countUnreadMessagesByContactId($contactId) {
        return $this->select(['count(*) as count'])
            ->where('contact_id', '=', $contactId)
            ->where('is_read', '=', 0)
            ->where('sender', '!=', 'user')
            ->row();
    }

    public function countUnreadMessagesByContactIdForAdmin($contactId) {
        return $this->select(['count(*) as count'])
            ->where('contact_id', '=', $contactId)
            ->where('is_read', '=', 0)
            ->where('sender', '!=', 'admin')
            ->row();
    }

    public function markMessagesAsRead($contactId) {
        return $this->update(['is_read' => 1])
            ->where('contact_id', '=', $contactId)
            ->where('sender', '=', 'admin')
            ->execute();
    }

    public function markMessagesAsReadForAdmin($contactId) {
        return $this->update(['is_read' => 1])
            ->where('contact_id', '=', $contactId)
            ->where('sender', '=', 'user')
            ->execute();
    }
}
