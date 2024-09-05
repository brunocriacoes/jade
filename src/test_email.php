<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    // Configurações do servidor SMTP
    $mail->isSMTP();
    $mail->Host       = getenv('SMTP_HOST');            // Host SMTP
    $mail->SMTPAuth   = true;
    $mail->Username   = getenv('SMTP_USER');            // Email do remetente
    $mail->Password   = getenv('SMTP_PASSWORD');        // Senha ou App Password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // TLS
    $mail->Port       = 587;                            // Porta SMTP

    // Configurações de envio
    $mail->setFrom(getenv('SMTP_USER'), 'Teste de Envio');   // Email do remetente
    $mail->addAddress('maximizebot@gmail.com');           // Email do destinatário

    // Conteúdo do email
    $mail->isHTML(true);
    $mail->Subject = 'Teste de Email - PHPMailer';
    $mail->Body    = 'Este é um teste de envio de email usando PHPMailer a partir de um container!';
    $mail->AltBody = 'Este é o conteúdo alternativo em texto puro.';

    // Enviar email
    $mail->send();
    echo 'Email enviado com sucesso!';
} catch (Exception $e) {
    echo "Erro no envio do email: {$mail->ErrorInfo}";
}
