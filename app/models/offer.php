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

    public function getOffersByUserId($userId)
    {
        $offer = $this->select([
                'offers.*', 
                'services.name AS service_name', 
                'categories.name AS category_name',
                'car_types.name AS car_type_name',
                'cities.name AS city_name',
                'countries.name AS country_name',
        ])
        ->join('services', 'offers.service_id = services.id')
        ->join('car_types', 'offers.car_type_id = car_types.id')
        ->join('categories', 'offers.category_id = categories.id')
        ->join('cities', 'offers.city_id = cities.id')
        ->join('countries', 'offers.country_id = countries.id')
        ->where('offers.user_id', '=', $userId)
        ->where('is_active','=',1)
        ->all();
        
        return $offer;
    }

    public function getAllWithPaginated($service_id = null, $car_type_id = null, $category_id = null, $model_from = null, $country_id =null , $page = 1, $limit = 9)
    {
        $offset = ($page - 1) * $limit;
        $this->select([
            'offers.*', 
            'services.name AS service_name', 
            'categories.name AS category_name',
            'car_types.name AS car_type_name',
            'cities.name AS city_name',
            'countries.name AS country_name',
            'favorites.id AS favorite_id'
        ])
        ->join('services', 'offers.service_id = services.id')
        ->join('car_types', 'offers.car_type_id = car_types.id')
        ->join('categories', 'offers.category_id = categories.id')
        ->join('cities', 'offers.city_id = cities.id')
        ->join('countries', 'offers.country_id = countries.id');
        
        $userId = session::Get('user')['id'] ?? 0;

        $this->leftJoin('favorites', 'offers.id = favorites.offer_id AND favorites.user_id = '.$userId);
        
        if ($service_id) {
            $this->where('offers.service_id', '=', $service_id);
        }
        if ($country_id) {
            $this->where('offers.country_id', '=', $country_id);
        }
        if ($car_type_id) {
            $this->where('offers.car_type_id', '=', $car_type_id);
        }
        if ($category_id) {
            $this->where('offers.category_id', '=', $category_id);
        }
        if ($model_from) {
            $this->where('offers.car_model_from', '<=', $model_from)
                    ->where('offers.car_model_to', '>=', $model_from);
        }
        
        $this->where('is_active', '=', 1);
    
        $totalQuery = clone $this;
        $totalQuery->select(['COUNT(*) AS total_count']);
        $totalCountResult = $totalQuery->row();
        $totalCount = $totalCountResult['total_count'] ?? 0;
    
        $this->sql .= "Order By Id DESC LIMIT $limit OFFSET $offset";
        $results = $this->all();
    
        $hasNextPage = (($page * $limit) < $totalCount);
    
        foreach ($results as &$result) {
            $result['is_favorite'] = !empty($result['favorite_id']);
        }
    
        return [
            'offers' => $results,
            'hasNextPage' => $hasNextPage,
            'currentPage' => $page,
            'totalPages' => ceil($totalCount / $limit)
        ];
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
    
    public function checkIfExist($id)
    {
        return $this->select()->where('id', '=', $id)->row();
    }

    public function getById($id)
    {
        $offer = $this->select([
                'offers.*', 
                'services.name AS service_name', 
                'categories.name AS category_name',
                'car_types.name AS car_type_name',
                'cities.name AS city_name',
                'countries.name AS country_name',
        ])
        ->join('services', 'offers.service_id = services.id')
        ->join('car_types', 'offers.car_type_id = car_types.id')
        ->join('categories', 'offers.category_id = categories.id')
        ->join('cities', 'offers.city_id = cities.id')
        ->join('countries', 'offers.country_id = countries.id')
        ->where('offers.id', '=', $id)
        ->where('is_active','=',1)
        ->row();
        
        if ($offer) {
            $offer['other_images'] = $this->getRelatedImages($id);
            array_unshift($offer['other_images'], [
                'id' => 1,
                'offer_id' => 0,
                'image' => $offer['image'],
                'order' => 1,
            ]);
            $offer['comments'] = $this->getRelatedComments($id);
        }
        if($offer && session::Get('user'))
        {
            $offer['is_favorite']     = $this->isOfferInFavorites($id,session::Get('user')['id']);
            $offer['is_follow_owner'] = $this->isFollowOwner($offer['user_id'],session::Get('user')['id']);
        }else{
            $offer['is_favorite']     = 0;
            $offer['is_follow_owner'] = 0;
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

    public function updateRowForSpecificUser($data)
    {
        $id = $data['id'];
        $user_id = $data['user_id'];
        unset($data['id']);
        unset($data['user_id']);
        $this->update($data)->where('id', '=', $id)->where('user_id', '=', $user_id);
        return $this->execute();
    }

    public function deleteRow($id)
    {
        return $this->delete($id)->execute();
    }

    private function getRelatedImages($offerId)
    {
        $this->sql = "SELECT * FROM `offer_images` WHERE offer_id = '" . mysqli_real_escape_string($this->connection, $offerId) . "' ORDER BY `order` ASC";
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

    public function isOfferInFavorites($offerId, $userId)
    {
        $this->sql = "
            SELECT COUNT(*) as total
            FROM favorites
            WHERE offer_id = '" . mysqli_real_escape_string($this->connection, $offerId) . "' 
            AND user_id = '" . mysqli_real_escape_string($this->connection, $userId) . "'
        ";
    
        $result = $this->row();
    
        return $result['total'] > 0;
    }

    public function isFollowOwner($owner_id, $userId)
    {
        $this->sql = "
            SELECT COUNT(*) as total
            FROM user_follows
            WHERE follower_id = '" . mysqli_real_escape_string($this->connection, $userId) . "' 
            AND following_id = '" . mysqli_real_escape_string($this->connection, $owner_id) . "'
        ";
    
        $result = $this->row();
    
        return $result['total'] > 0;
    }
}