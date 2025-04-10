<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/PHPMailer/PHPMailer.php';
require 'src/PHPMailer/Exception.php';
require 'src/PHPMailer/SMTP.php';

function sendVerificationEmail($userEmail, $verificationCode) {
    $mail = new PHPMailer(true);
    
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'regenearth.nexus@gmail.com';  // SMTP username
        $mail->Password = 'ybkh fmlb defv mglm';  // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('regenearth.nexus@gmail.com', 'ReGenEarth');
        $mail->addAddress($userEmail);

        $mail->isHTML(true);
        $mail->Subject = 'Verify Your Account on ReGenEarth';
        $mail->Body    = "Hello, <br><br>Please use the following code to verify your account: <b>$verificationCode</b>";

        $mail->send();
        echo 'Verification email has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

function sendResetPasswordEmail($userEmail, $resetCode) {
    $mail = new PHPMailer(true);
    
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'regenearth.nexus@gmail.com';
        $mail->Password = 'ybkh fmlb defv mglm';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('regenearth.nexus@gmail.com', 'ReGenEarth');
        $mail->addAddress($userEmail);

        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Request';
        $mail->Body    = "Hello, <br><br>To reset your password, use the following code: <b>$resetCode</b>";

        $mail->send();
        echo 'Password reset email has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
