<?php

namespace App\UseCases;

use App\Model\User;
use Core\Jwt;
use Core\Env;

class LoginCase
{
    private $email;
    private $pass;
    private $user;
    private $jwt;


    public function __construct($params)
    {
        $this->email = $params['email'];
        $this->pass = $params['pass'];
        $this->user = new User();
        $this->jwt = new Jwt(Env::get("SECRET"));
    }

    public function emailValid()
    {
        return filter_var($this->email, FILTER_VALIDATE_EMAIL);
    }

    public function userValid()
    {
        return $this->user->isLogin($this->email, $this->pass);
    }

    public function execute()
    {
        $jwt = $this->jwt->createToken(["email"=>$this->email]);
        return ["jwt"=>$jwt];
    }
}
