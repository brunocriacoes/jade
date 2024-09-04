<?php

namespace App\UseCases;

use App\Model\Store;

class RegisterStoreCase
{
    private $params;

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function validateName()
    {
        return !empty($this->params['name']);
    }

    public function validateEmail()
    {
        return filter_var($this->params['email'], FILTER_VALIDATE_EMAIL);
    }

    public function execute()
    {
        $storeModel = new Store();
        return $storeModel->create($this->params);
    }
}
