
<?php

require_once __DIR__ . '/mail_config.php';

$recipientEmail = $_ENV['MAIL_USERNAME'];
$recipientName = 'Test User';

if (sendWelcomeEmail($recipientEmail, $recipientName)) {
    echo 'Test email sent successfully!';
} else {
    echo 'The email could not be sent. Check your PHP error log.';
}
