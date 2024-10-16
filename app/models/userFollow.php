<?php

namespace MVC\models;

use MVC\core\model;

class userFollow extends model{
    
    public function __construct()
    {
        parent::__construct();  
        $this->table = "user_follows";
    }

    public function create($data)
    {
        $row = $this->select()
            ->where('follower_id', '=', $data['follower_id'])
            ->where('following_id', '=', $data['following_id'])
            ->row();
        if($row)
        {
            return $this->delete($row['id'])->execute();
        }
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->insert($data)->execute();
    }

    public function getFollowers($user_id)
    {
        return $this->select(['follower_id'])
            ->where('following_id', '=', $user_id)
            ->all();
    }
}