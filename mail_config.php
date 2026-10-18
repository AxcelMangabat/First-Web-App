<?php

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

function sendWelcomeEmail(string $recipientEmail, string $recipientName): bool
{
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->SMTPDebug = 2;

        $mail->Debugoutput = function ($message, $level) {
            error_log("SMTP DEBUG [$level]: $message");
        };
        $mail->Host = $_ENV['MAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['MAIL_USERNAME'];
        $mail->Password = $_ENV['MAIL_PASSWORD'];
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = (int) $_ENV['MAIL_PORT'];

        $mail->CharSet = 'UTF-8';

        $mail->setFrom(
            $_ENV['MAIL_FROM_ADDRESS'],
            $_ENV['MAIL_FROM_NAME']
        );

        $mail->addAddress($recipientEmail, $recipientName);

        $safeName = htmlspecialchars(
            $recipientName,
            ENT_QUOTES,
            'UTF-8'
        );

        $mail->isHTML(true);
        $mail->Subject = 'Welcome to Student CRUD System';
        $mail->Body = "
            <h2>Welcome, {$safeName}!</h2>
            <p>Your account has been created successfully.</p>
            <p>You can now log in to the Student CRUD System.</p>
        ";

        $mail->AltBody =
            "Welcome, {$recipientName}! Your account has been created successfully.";

        $mail->send();

        return true;

    } catch (Throwable $e) {
        error_log('Welcome email failed: ' . $e->getMessage());
        return false;
    }
}
