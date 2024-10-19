<?php

namespace MVC\models;

use MVC\core\model;

class city extends model{
    
    public function __construct()
    {
        parent::__construct();  
        $this->table = "cities";
    }

    public function create($data)
    {
        return $this->insert($data)->execute();
    }

    public function getAll()
    {
        return $this->select(['cities.*','countries.name As country_name'])
            ->join('countries','cities.country_id = countries.id')
            ->all();
    }

    public function cityByCountryId($countryId){
        return $this->select()->where('country_id','=',$countryId)->all();
    }

    public function checkCityWithCountry($cityId,$countryId){
        return $this
            ->select()
            ->where('id','=',$cityId)
            ->where('country_id','=',$countryId)
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