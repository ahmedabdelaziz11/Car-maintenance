<?php

namespace MVC\models;

use MVC\core\model;
use MVC\core\session;

class favorite extends model{
    
    public function __construct()
    {
        parent::__construct();  
        $this->table = "favorites";
    }

    public function toggleFavorite($favorite_id)
    {
        $result = $this->select()->where('offer_id','=',$favorite_id)->where('user_id','=',session::Get('user')['id'])->row();
        if($result){
            return $this->delete($result['id'])->execute();
        }else{
            return $this->insert(['user_id' => session::Get('user')['id'],'offer_id' => $favorite_id])->execute();
        }
    }

    public function deleteRow($id)
    {
        return $this->delete($id)->execute();
    }
}