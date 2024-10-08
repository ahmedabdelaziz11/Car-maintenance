<?php

namespace MVC\models;

use MVC\core\model;

class category extends model{
    
    public function __construct()
    {
        parent::__construct();  
        $this->table = "categories";
    }

    public function create($data)
    {
        return $this->insert($data)->execute();
    }

    public function getAll()
    {
        return $this->select(['categories.*','car_types.name As car_type_name'])
            ->join('car_types','categories.car_type_id = car_types.id')
            ->all();
    }

    public function categoryByCarTypeId($carTypeId){
        return $this->select()->where('car_type_id','=',$carTypeId)->all();
    }

    public function checkCategoryWithCarType($categoryId,$carTypeId){
        return $this
            ->select()
            ->where('id','=',$categoryId)
            ->where('car_type_id','=',$carTypeId)
            ->row();
    }

    public function getById($id)
    {
        return $this->select()->where('id', '=', $id)->row();
    }

    public function getByName($name, $id = null)
    {
        $query = $this->select()->where('name', '=', $name);
    
        if ($id !== null) {
            $query->where('id', '!=', $id);
        }
    
        return $query->row();
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