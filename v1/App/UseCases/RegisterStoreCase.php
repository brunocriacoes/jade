<?php

namespace App\UseCases;

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
        $storeModel = new \App\Models\Store();
        return $storeModel->create($this->params);
    }
}
