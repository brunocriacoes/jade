<?php

namespace App\Template;

class RecoverPass
{

    static function subject()
    {
        return "Recuperação de Senha";
    }

    static function body($code, $email)
    {
        $content = "";
        $content .= "Olá, " . PHP_EOL;
        $content .= PHP_EOL;
        $content .= "Recebemos uma solicitação para redefinir a senha associada ao seu e-mail. " . PHP_EOL;
        $content .= "Para concluir o processo de recuperação, por favor, clique no link abaixo: " . PHP_EOL;
        $content .= PHP_EOL;
        $content .= "https://api.paramour.com.br/redefinir-senha.html?codigo={$code}&email={$email} " . PHP_EOL;
        $content .= PHP_EOL;
        $content .= "Se você não solicitou a redefinição de senha, por favor, ignore este e-mail. " . PHP_EOL;
        $content .= "Nenhuma ação adicional é necessária. " . PHP_EOL;
        $content .= PHP_EOL;
        $content .= "Este link é válido por 24 horas. Após esse período, " . PHP_EOL;
        $content .= "você precisará solicitar novamente a recuperação de senha. " . PHP_EOL;
        $content .= PHP_EOL;
        $content .= "Atenciosamente,   " . PHP_EOL;
        $content .= "Paramour " . PHP_EOL;
        return $content;
    }
}
