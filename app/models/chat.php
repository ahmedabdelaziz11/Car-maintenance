<?php

namespace MVC\models;

use MVC\core\model;
use MVC\core\session;

class chat extends model{
    
    public function __construct()
    {
        parent::__construct();  
        $this->table = "chats";
    }

    public function create($data)
    {
        return $this->insert($data)->execute();
    }

    public function getChat($user_id)
    {
        $current_user_id = session::get('user')['id'];

        $this->sql = "SELECT * FROM chats 
                        WHERE (sender_id = $user_id AND receiver_id = $current_user_id)
                        OR (sender_id = $current_user_id AND receiver_id = $user_id) 
                        ORDER BY created_at ASC";
    
        return $this->all(); 
    }

    public function getChatUsers()
    {
        $currentUserId = session::get('user')['id'];

        $this->sql = "
            SELECT DISTINCT users.* 
            FROM chats 
            JOIN users ON 
                (chats.sender_id = users.id OR chats.receiver_id = users.id)
            WHERE (chats.sender_id = $currentUserId OR chats.receiver_id = $currentUserId) 
            AND users.id != $currentUserId
        ";

        return $this->all(); 
    }
}