<?php

namespace App\UseCases;

use App\help\SendMail;
use App\Template\RecoverPass as Email;
use App\help\Keygen;
use App\Model\User;



class RecoverPass {

    public $email;

    public function __construct($data) {
        $this->email = $data["email"];
    }

    function execute() {
        $user = new User();
        $isExist = $user->emailExist($this->email);
        $isSend = false;
        if($isExist) {
            $gen = new Keygen( 15 );
            $gen->setSalt($this->email);
            $code = $gen->generate();
            $isSend = SendMail::go( $this->email, Email::subject(), Email::body($code, $this->email) );
        }
        return [
            "isSend" => $isSend,
        ];
    }

}