<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Autoload via Composer or manually include
require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method Not Allowed');
}

// 1) Sanitize & validate
$name    = trim($_POST['name'] ?? '');
$email   = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
$phone   = trim($_POST['phone'] ?? '');
$message = trim($_POST['message'] ?? '');

if (!$name || !$email || !$message) {
    http_response_code(400);
    exit('Please fill in all required fields.');
}

// 2) Configure PHPMailer
$mail = new PHPMailer(true);

try {
    // SMTP setup — replace these with your SMTP credentials:
    $mail->isSMTP();
    $mail->Host       = 'smtp.yourhost.com';        // e.g. smtp.gmail.com
    $mail->SMTPAuth   = true;
    $mail->Username   = 'smtp-username@domain.com';
    $mail->Password   = 'smtp-password';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Recipients
    $mail->setFrom($email, $name);
    $mail->addAddress('info@axiommedicalmanagement.com', 'Axiom Medical');
    $mail->addReplyTo($email, $name);

    // Content
    $mail->isHTML(false);
    $mail->Subject = "New message from {$name}";
    $mail->Body    = <<<EOT
You have received a new message from your website contact form.

Name:    {$name}
Email:   {$email}
Phone:   {$phone}

Message:
{$message}
EOT;

    // 3) Send
    $mail->send();

    // 4) Redirect on success
    header('Location: /thank-you.html');
    exit;

} catch (Exception $e) {
    // Log the error or display
    error_log("Mailer Error: {$mail->ErrorInfo}");
    http_response_code(500);
    exit('Sorry, something went wrong. Please try again later.');
}
