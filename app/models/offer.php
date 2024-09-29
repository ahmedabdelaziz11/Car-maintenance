<?php

namespace MVC\models;

use MVC\core\model;
use MVC\core\session;

class offer extends model{
    
    public function __construct()
    {
        parent::__construct();  
        $this->table = "offers";
    }

    public function getAll()
    {
        return $this->select()->where('is_active','=',1)->where('user_id','=',$_SESSION['user']['id'])->all();
    }

    public function getAllOffers()
    {
        return $this->select()->all();
    }   

    public function getAllWithPaginated($service_id = null, $category_id = null, $model_from = null, $model_to = null, $page = 1, $limit = 3)
    {
        $offset = ($page - 1) * $limit;
    
        $this->select(['offers.*','favorites.id AS favorite_id', 'services.name AS service_name', 'car_types.name AS car_type_name','categories.name AS category_name'])
            ->join('car_types', 'offers.car_type_id = car_types.id')
            ->join('services', 'offers.service_id = services.id')
            ->join('categories', 'offers.category_id = categories.id');

        $userId = session::Get('user')['id'] ?? 0;
        $this->leftJoin('favorites', 'offers.id = favorites.offer_id AND favorites.user_id = '.$userId);
        
    
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
        $this->where('is_active','=',1);
    
        $this->sql .= " LIMIT $limit OFFSET $offset";
        $results = $this->all();

        foreach ($results as &$result) {
            $result['is_favorite'] = !empty($result['favorite_id']);
        }
        return $results;
    }
    
    public function favoriteOffers()
    {
        $userId = session::Get('user')['id'] ?? null;
    
        if (!$userId) {
            return [];
        }
    
        $this->select(['offers.*', 'services.name AS service_name', 'car_types.name AS car_type_name', 'categories.name AS category_name'])
            ->join('favorites', 'offers.id = favorites.offer_id')
            ->join('car_types', 'offers.car_type_id = car_types.id')
            ->join('services', 'offers.service_id = services.id')
            ->join('categories', 'offers.category_id = categories.id')
            ->where('favorites.user_id', '=', $userId)
            ->where('is_active','=',1);
    
        return $this->all();
    }

    public function getById($id)
    {
        $offer = $this->select(['offers.*', 'services.name AS service_name', 'categories.name AS category_name','car_types.name AS car_type_name'])
        ->join('services', 'offers.service_id = services.id')
        ->join('car_types', 'offers.car_type_id = car_types.id')
        ->join('categories', 'offers.category_id = categories.id')
        ->where('offers.id', '=', $id)
        ->where('is_active','=',1)
        ->row();
        if ($offer) {
            $offer['other_images'] = $this->getRelatedImages($id);
            $offer['comments']     = $this->getRelatedComments($id);
        }
        return $offer;
    }

    public function getOfferByIdForAdmins($id)
    {
        $offer = $this->select()
        ->where('offers.id', '=', $id)
        ->row();
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

    private function getRelatedComments($offerId)
    {
        $this->sql = "
            SELECT offer_comments.*, users.name as user_name 
            FROM offer_comments 
            JOIN users ON offer_comments.user_id = users.id 
            WHERE offer_comments.offer_id = '" . mysqli_real_escape_string($this->connection, $offerId) . "'
        ";        
        return $this->all();
    }
}