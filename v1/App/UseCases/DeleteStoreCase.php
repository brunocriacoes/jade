<?php

namespace App\UseCases;

class DeleteStoreCase
{
    private $params;

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function validatePublicId()
    {
        return !empty($this->params['publicId']);
    }

    public function execute()
    {
        $storeModel = new \App\Models\Store();
        return $storeModel->delete($this->params['publicId']);
    }
}

