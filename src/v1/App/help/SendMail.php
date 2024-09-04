<?php

namespace App\help;

class SendMail {

    static function go( $to, $subject, $message ) {        
        $headers = "From: noreply@seusite.com\r\n";
        $headers .= "Reply-To: suporte@seusite.com\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";        
        return mail($to, $subject, $message, $headers);
    }
}