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

        $this->sql = "UPDATE chats 
            SET is_read = 1 
            WHERE sender_id = $user_id 
            AND is_read = 0";
        $this->execute();  

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
            SELECT 
                users.*,
                (
                    SELECT COUNT(*) 
                    FROM chats 
                    WHERE chats.sender_id = users.id 
                    AND chats.receiver_id = $currentUserId 
                    AND chats.is_read = 0
                ) AS unread_count
            FROM chats 
            JOIN users ON 
                (chats.sender_id = users.id OR chats.receiver_id = users.id)
            WHERE 
                (chats.sender_id = $currentUserId OR chats.receiver_id = $currentUserId) 
                AND users.id != $currentUserId
            GROUP BY users.id
        ";
    
        return $this->all(); 
    }

    public function getUnreadMessages()
    {
        $currentUserId = session::get('user')['id'] ?? 0;
        $row = $this->select(['count(*) as total'])->where('receiver_id','=',$currentUserId)->where('is_read','=',0)->row();
        return $row['total'];
    }
}