<?php

namespace App\UseCases;

class LoginCase
{
    private $email;
    private $senha;

    public function __construct($params)
    {
        $this->email = $params['email'];
        $this->senha = $params['senha'];
    }

    public function validateEmail()
    {
        return filter_var($this->email, FILTER_VALIDATE_EMAIL);
    }

    public function validatePassword()
    {
        return strlen($this->senha) > 5;
    }

    public function execute()
    {
        $user = (new \App\Models\User())->getByEmail($this->email);
        if ($user && password_verify($this->senha, $user['pass'])) {
            return ["token" => "asdlkgnsdfgksnfdghpksdfgnh"];
        } else {
            return ["error" => "Login failed"];
        }
    }
}
