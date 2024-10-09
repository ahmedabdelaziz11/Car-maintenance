<?php

namespace MVC\models;

use MVC\core\model;

class report extends model{
    
    public function __construct()
    {
        parent::__construct();  
        $this->table = "reports";
    }

    public function getAllReports() {
        $this->select([
            'reports.*',
            'offers.title as offer_title', 
            'offer_user.name as offer_user_name', 
            'reporter.name as reporter_name',
            'offer_comments.comment as comment_text', 
            'comment_user.name as comment_user_name'
        ])
        ->leftJoin('offers', 'reports.offer_id = offers.id')
        ->leftJoin('users as offer_user', 'offers.user_id = offer_user.id')
        ->leftJoin('offer_comments', 'reports.comment_id = offer_comments.id') 
        ->leftJoin('users as comment_user', 'offer_comments.user_id = comment_user.id')
        ->join('users as reporter', 'reports.user_id = reporter.id')
        ->orderBy('created_at', 'DESC');

    return $this->all();
    }

    public function create($data)
    {
        $offer_id   = isset($data['offer_id'])  ? $data['offer_id'] : null;
        $comment_id = isset($data['comment_id'])  ? $data['comment_id'] : null;
        if(!$this->reportExists(
            $data['user_id'],
            $offer_id,
            $comment_id,
        ))
        {
            $data['created_at'] = date('Y-m-d H:i:s');
            return $this->insert($data)->execute();
        }
        return false;
    }

    public function deleteRow($id)
    {
        return $this->delete($id)->execute();
    }

    public function reportExists($user_id, $offer_id = null, $comment_id = null)
    {
        $this->select()->where('user_id', '=', $user_id);
        
        if ($offer_id) {
            $this->where('offer_id', '=', $offer_id);
        } elseif ($comment_id) {
            $this->where('comment_id', '=', $comment_id);
        }

        return $this->row();
    }
}