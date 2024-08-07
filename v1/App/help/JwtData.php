<?php

namespace App\help;

use Core\Jwt;
use Core\Request;


class JwtData {
    static function info() {
        $jwt = new Jwt($_ENV['SECRET']);
        $req = new Request();
        $token = $req->getHeader('Token');
        return $jwt->decodeToken($token);
    }
}