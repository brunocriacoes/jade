<?php

namespace App\UseCases;

class UpdateUserCase
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
        $userModel = new \App\Models\User();
        return $userModel->set($this->params['publicId'], $this->params);
    }
}
