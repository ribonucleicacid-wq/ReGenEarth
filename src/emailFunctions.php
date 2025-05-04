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
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'regenearth.nexus@gmail.com';
        $mail->Password = 'ybkh fmlb defv mglm';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('regenearth.nexus@gmail.com', 'ReGenEarth');
        $mail->addAddress($userEmail);

        $mail->addEmbeddedImage('assets/images/email_header.png', 'header_cid');
        $mail->isHTML(true);
        $mail->Subject = 'Action Required: Verify Your ReGenEarth Account';

        $bodyTemplate = getEmailTemplate('verification', [
            '{{MAIN_CONTENT}}' => '
                Thank you for joining <strong>ReGenEarth</strong>. To verify your account and complete your registration, please use the verification code below:
                <p style="margin:0 0 30px 0;font-size:24px;font-weight:bold;color:#2E7D32;text-align:center;">' . htmlspecialchars($verificationCode) . '</p>
                If you did not initiate this request, please safely ignore this email.
            '
        ]);

        $mail->Body = $bodyTemplate;

        $mail->send();
        echo 'Verification email has been sent';
    } catch (Exception $e) {
        echo "Verification email could not be sent. Mailer Error: {$mail->ErrorInfo}";
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

        $mail->addEmbeddedImage('assets/images/email_header.png', 'header_cid');
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Request - ReGenEarth';

        $bodyTemplate = getEmailTemplate('reset', [
            '{{MAIN_CONTENT}}' => '
                We have received a request to reset your password. Please use the code below to proceed:
                <p style="margin:0 0 30px 0;font-size:24px;font-weight:bold;color:#2E7D32;text-align:center;">' . htmlspecialchars($resetCode) . '</p>
                If you did not request a password reset, no further action is required.
            '
        ]);

        $mail->Body = $bodyTemplate;

        $mail->send();
        echo 'Password reset email has been sent';
    } catch (Exception $e) {
        echo "Password reset email could not be sent. Mailer Error: {$mail->ErrorInfo}";
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

        $mail->addEmbeddedImage('assets/images/email_header.png', 'header_cid');
        $mail->isHTML(true);
        $mail->Subject = 'Welcome to ReGenEarth - Your Login Credentials';

        $bodyTemplate = getEmailTemplate('credentials', [
            '{{MAIN_CONTENT}}' => '
                Your account has been successfully created. Below are your login credentials:<br><br>
                <strong>Email:</strong> ' . htmlspecialchars($userEmail) . '<br>
                <strong>Temporary Password:</strong> ' . htmlspecialchars($defaultPassword) . '<br><br>
                Please log in and update your password at your earliest convenience.
            '
        ]);

        $mail->Body = $bodyTemplate;

        $mail->send();
    } catch (Exception $e) {
        error_log("Failed to send new user credentials email: {$mail->ErrorInfo}");
    }
}

function getEmailTemplate($type, $replacements = [])
{
    $html = '
    <html>
      <body style="Margin:0;padding:0;background-color:#f4f4f4;font-family: Arial, sans-serif;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
          <tr>
            <td align="center" style="padding:20px 0;">
              <table border="0" cellpadding="0" cellspacing="0" width="600" style="background-color:#ffffff;border-radius:8px;overflow:hidden;">
                <tr>
                  <td align="center" style="padding:0;">
                    <img src="cid:header_cid" alt="ReGenEarth Header" style="display:block;width:100%;max-width:600px;height:auto;">
                  </td>
                </tr>
                <tr>
                  <td style="padding:30px 40px 20px 40px;color:#333333;font-size:16px;line-height:1.6;">
                    <p style="margin:0 0 20px 0;">
                      Dear Valued User,
                    </p>
                    <p style="margin:0 0 20px 0;">
                      {{MAIN_CONTENT}}
                    </p>
                    <p style="margin:40px 0 0 0;">
                      Sincerely,<br>
                      <strong>The ReGenEarth Team</strong>
                    </p>
                  </td>
                </tr>
                <tr>
                  <td align="center" style="padding:20px;background-color:#e0e0e0;font-size:12px;color:#666;">
                    &copy; ' . date('Y') . ' ReGenEarth. All rights reserved.
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </body>
    </html>
    ';

    foreach ($replacements as $placeholder => $value) {
        $html = str_replace($placeholder, $value, $html);
    }

    return $html;
}
?>