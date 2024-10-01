<?php

namespace MVC\models;

use MVC\core\model;
use MVC\core\session;

class notification extends model{
    
    public function __construct()
    {
        parent::__construct();  
        $this->table = "notifications";
    }

    public function create($data)
    {
        return $this->insert($data)->execute();
    }

    public function getAll()
    {
        return $this->select(['id','message','is_read','date','offer_id'])
                    ->where('user_id','=',session::get('user')['id'])
                    ->orderBy('id','DESC')
                    ->limit(15)
                    ->all();
    }

    public function updateRow($data)
    {
        $id = $data['id'];
        unset($data['id']);
        $this->update($data)->where('id', '=', $id);
        return $this->execute();
    }

    public function deleteRow($id)
    {
        return $this->delete($id)->execute();
    }
}