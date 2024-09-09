<?php

namespace App\UseCases;

use App\help\Keygen;
use App\Model\User;
use App\help\Pass;
use Core\Crip;

class AlterPass {

    public $email;
    public $code;
    public $pass;

    public function __construct($data) {
        $this->email = $data["email"];
        $this->code = $data["code"];
        $this->pass = $data["pass"];
    }

    function isCode() {
        $gen = new Keygen( 15 );
        $gen->setSalt($this->email);
        return $gen->validate($this->code);
    }

    function passValid() {
        return Pass::isValid($this->pass);
    }
    
    function isEmail() {
        $user = new User();
        return $user->emailExist($this->email);
    }

    function execute() {
        $user = new User();
        $data = $user->getByEmail($this->email);
        $publicId = $data['publicId'];
        $pass = $this->pass;
        $user->set($publicId,[
            "pass" => $pass
        ]);
        return [];
    }

}