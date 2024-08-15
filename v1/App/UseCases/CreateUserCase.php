<?php

namespace App\UseCases;

use App\help\Pass;
use App\Model\User;
use App\Model\Phone;

class CreateUserCase
{
    private $params;
    private $client;

    public function __construct($params)
    {
        $this->params = $params;
        $this->client = new User();
    }

    public function validateEmail()
    {
        return filter_var($this->params['email'], FILTER_VALIDATE_EMAIL);
    }

    public function validatePassword()
    {
        return Pass::isValid($this->params['pass']);
    }

    public function userExist()
    {
        $email = $this->params['email'];
        return !$this->client->emailExist($email);
    }

    public function execute()
    {
        $userModel = new User();
        return $userModel->create($this->params);
    }
}
