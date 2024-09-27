<?php

namespace MVC\models;

use MVC\core\model;

class offerImage extends model{
    
    public function __construct()
    {
        parent::__construct();  
        $this->table = "offer_images";
    }

    public function create($data)
    {
        return $this->insert($data)->execute();
    }

    public function deleteRow($id)
    {
        return $this->delete($id)->execute();
    }
}