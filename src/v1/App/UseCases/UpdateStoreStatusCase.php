<?php

namespace App\UseCases;

use App\Model\Store;

class UpdateStoreStatusCase
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
        return $storeModel->set($this->params['publicId'], ['status' => $this->params['status']]);
    }
}
