<?php

namespace MVC\models;

use MVC\core\model;

class follow extends model{
    
    public function __construct()
    {
        parent::__construct();  
        $this->table = "follows";
    }

    public function create($data)
    {
        return $this->insert($data)->execute();
    }

    public function getAll()
    {
        return $this->select()->all();
    }


    public function followExist($service_id,$category_id,$user_id)
    {
        return $this->select()
            ->where('service_id', '=', $service_id)
            ->where('category_id', '=', $category_id)
            ->where('user_id', '=', $user_id)
            ->row();
    }

    public function getUserIdsFollowsOffer($service_id,$category_id)
    {
        return $this->select(['user_id'])
                    ->where('service_id', '=', $service_id)
                    ->where('category_id', '=', $category_id)
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