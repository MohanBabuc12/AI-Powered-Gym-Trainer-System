<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

// Collect form data
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$message = $_POST['message'] ?? '';

if (!$name || !$email || !$message) {
    die('Please fill in all required fields.');
}

// Your Gmail credentials
$yourEmail = 'your_email@gmail.com';          // Replace with your Gmail
$appPassword = 'jrwe cbxz rftj dcwd'; // From Google App Passwords

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = $yourEmail;
    $mail->Password = $appPassword;
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Recipients
    $mail->setFrom($yourEmail, 'Stride Sync Website');
    $mail->addAddress($yourEmail); // You will receive the form messages here

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'New Contact Message from Stride Sync';
    $mail->Body    = "
        <h2>Contact Form Submission</h2>
        <p><strong>Name:</strong> $name</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Message:</strong><br>$message</p>
    ";

    $mail->send();
    echo "<script>alert('Your message has been sent!'); window.location.href='contact.php';</script>";
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
