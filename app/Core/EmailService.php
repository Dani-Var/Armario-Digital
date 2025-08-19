<?php

namespace App\Core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailService
{
    private PHPMailer $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        // Configurações do servidor SMTP
        $this->mail->isSMTP();
        $this->mail->Host = 'smtp.gmail.com'; // Altere para o seu servidor SMTP
        $this->mail->SMTPAuth = true;
        $this->mail->Username = 'seu_email@gmail.com'; // Altere para o seu e-mail
        $this->mail->Password = 'sua_senha_de_aplicativo'; // Altere para a sua senha de aplicativo ou senha do e-mail
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port = 587;

        // Remetente
        $this->mail->setFrom('seu_email@gmail.com', 'Closet Fashion'); // Altere para o seu e-mail e nome
    }

    public function sendEmail(string $to, string $subject, string $body): bool
    {
        try {
            // Log the email content instead of sending it
            file_put_contents("/var/www/html/closet_fashion/email_log.txt", "To: $to\nSubject: $subject\nBody: $body\n\n", FILE_APPEND);
            return true;
        } catch (Exception $e) {
            error_log("Erro ao enviar e-mail: {$this->mail->ErrorInfo}");
            return false;
        }
    }
}

