<?php

namespace MVC\models;

use MVC\core\model;

class service extends model{
    
    public function __construct()
    {
        parent::__construct();  
        $this->table = "services";
    }

    public function create($data)
    {
        return $this->insert($data)->execute();
    }

    public function getAll()
    {
        return $this->select(['id','name','image'])->all();
    }

    public function getById($id)
    {
        return $this->select()->where('id', '=', $id)->row();
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