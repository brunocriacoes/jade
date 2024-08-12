<?php

namespace App\UseCases;

class CreateUserCase
{
    private $params;

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function validateEmail()
    {
        return filter_var($this->params['email'], FILTER_VALIDATE_EMAIL);
    }

    public function validatePassword()
    {
        return strlen($this->params['pass']) > 5;
    }

    public function execute()
    {
        $userModel = new \App\Models\User();
        return $userModel->create($this->params);
    }
}
