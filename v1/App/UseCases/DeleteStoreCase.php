<?php

namespace App\UseCases;

use App\Model\Store;

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
        $storeModel = new Store();
        $storeModel->delete($this->params['publicId']);
        return [];
    }
}

