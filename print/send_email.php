
<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;

$lr_id = $_GET['lr_id'];
$filePath = "lr_pdf/LR_$lr_id.pdf";

$mail = new PHPMailer(true);

$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'your@gmail.com';
$mail->Password = 'your-app-password';
$mail->SMTPSecure = 'tls';
$mail->Port = 587;

$mail->setFrom('your@gmail.com', 'Transport');
$mail->addAddress($_GET['email']);

$mail->Subject = 'LR Copy';
$mail->Body = 'Attached LR PDF';

$mail->addAttachment($filePath);

$mail->send();

echo "Email Sent";
?>