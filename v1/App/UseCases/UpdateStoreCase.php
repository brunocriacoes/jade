<?php

namespace App\UseCases;

class UpdateStoreCase
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

    public function validateEmail()
    {
        return filter_var($this->params['email'], FILTER_VALIDATE_EMAIL);
    }

    public function execute()
    {
        $storeModel = new \App\Models\Store();
        return $storeModel->set($this->params['publicId'], $this->params);
    }
}
