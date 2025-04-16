<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/PHPMailer/PHPMailer.php';
require 'src/PHPMailer/Exception.php';
require 'src/PHPMailer/SMTP.php';

function sendVerificationEmail($userEmail, $verificationCode)
{
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

        $mail->addEmbeddedImage('assets/images/cover.png', 'banner_cid'); // Add logo image
        $mail->isHTML(true);
        $mail->Subject = 'Verify Your Account on ReGenEarth';
        $mail->Body = '
            <html>
                <body>
                    <img src="cid:banner_cid" alt="Banner" style="width:100%; max-width:600px;">
                    <p>
                        Dear Valued User,<br><br>

                        Thank you for registering with us. To complete the verification process and activate your account, please use the verification code provided below:<br><br>

                        <b>' . $verificationCode . '</b><br><br>

                        If you did not initiate this request, please disregard this email.<br><br>

                        Best regards,<br>
                        The ReGenEarth Team
                    </p>
                </body>
            </html>
        ';

        $mail->send();
        echo 'Verification email has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

function sendResetPasswordEmail($userEmail, $resetCode)
{
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
        $mail->Body = "Hello, <br><br>To reset your password, use the following code: <b>$resetCode</b>";

        $mail->send();
        echo 'Password reset email has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
function sendNewUserCredentialsEmail($userEmail, $username, $defaultPassword)
{
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

        $mail->addEmbeddedImage('assets/images/cover.png', 'banner_cid');
        $mail->isHTML(true);
        $mail->Subject = 'Welcome to ReGenEarth – Your Account Details';
        $mail->Body = '
            <html>
                <body>
                    <img src="cid:banner_cid" alt="Banner" style="width:100%; max-width:600px;">
                    <p>
                        Hi ' . htmlspecialchars($username) . ',<br><br>

                        Your account has been successfully created by the admin.<br><br>

                        You can now log in with the following credentials:<br><br>

                        <b>Email:</b> ' . htmlspecialchars($userEmail) . '<br>
                        <b>Temporary Password:</b> ' . $defaultPassword . '<br><br>

                        Please log in and update your password at your earliest convenience.<br><br>

                        Welcome to ReGenEarth!<br><br>

                        Sincerely,<br>
                        The ReGenEarth Team
                    </p>
                </body>
            </html>
        ';

        $mail->send();
    } catch (Exception $e) {
        error_log("Failed to send new user email: {$mail->ErrorInfo}");
    }
}

?>