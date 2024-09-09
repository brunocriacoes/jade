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
        $content .= "Olá,<br>";
        $content .= "<br>";
        $content .= "Recebemos uma solicitação para redefinir a senha associada ao seu e-mail.<br>";
        $content .= "Para concluir o processo de recuperação, por favor, clique no link abaixo:<br>";
        $content .= "<br>";
        $content .= "<a href='https://api.paramour.com.br/redefinir-senha.html?codigo={$code}&email={$email}'>Clique aqui para redefinir sua senha</a><br>";
        $content .= "<br>";
        $content .= "Se você não solicitou a redefinição de senha, por favor, ignore este e-mail.<br>";
        $content .= "Nenhuma ação adicional é necessária.<br>";
        $content .= "<br>";
        $content .= "Este link é válido por 15 minutos. Após esse período,<br>";
        $content .= "você precisará solicitar novamente a recuperação de senha.<br>";
        $content .= "<br>";
        $content .= "Atenciosamente,<br>";
        $content .= "Paramour<br>";


        return mb_convert_encoding($content, 'UTF-8', 'auto');
    }
}
