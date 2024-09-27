<?php

namespace MVC\models;

use MVC\core\model;

class offer extends model{
    
    public function __construct()
    {
        parent::__construct();  
        $this->table = "offers";
    }

    public function getAll()
    {
        return $this->select()->where('user_id','=',$_SESSION['user']['id'])->all();
    }

    public function getAllWithPaginated($service_id = null, $category_id = null, $model_from = null, $model_to = null, $page = 1, $limit = 3)
    {
        $offset = ($page - 1) * $limit;
    
        $this->select(['offers.*', 'services.name AS service_name', 'categories.name AS category_name'])
            ->join('services', 'offers.service_id = services.id')
            ->join('categories', 'offers.category_id = categories.id');
    
        if ($service_id) {
            $this->where('offers.service_id', '=', $service_id);
        }
        if ($category_id) {
            $this->where('offers.category_id', '=', $category_id);
        }
        if ($model_from) {
            $this->where('offers.car_model_from', '>=', $model_from);
        }
        if ($model_to) {
            $this->where('offers.car_model_to', '<=', $model_to);
        }
    
        $this->sql .= " LIMIT $limit OFFSET $offset";
    
        return $this->all();
    }
    

    public function getById($id)
    {
        $offer = $this->select()->where('id', '=', $id)->row();
        if ($offer) {
            $offer['other_images'] = $this->getRelatedImages($id);
        }
        return $offer;
    }

    public function create($data)
    {
        return $this->insert($data)->execute();
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

    private function getRelatedImages($offerId)
    {
        $this->sql = "SELECT * FROM `offer_images` WHERE offer_id = '" . mysqli_real_escape_string($this->connection, $offerId) . "'";
        return $this->all();
    }
}