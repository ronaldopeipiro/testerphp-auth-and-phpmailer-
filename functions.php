<?php
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require_once 'vendor/autoload.php';

function sendPasswordReset($email, $token)
{
    $mail = new PHPMailer(true);
    try {
        // Set up SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Ganti dengan host SMTP Anda
        $mail->SMTPAuth   = true;
        $mail->Username   = 'appkejariberau@gmail.com'; // Ganti dengan email Anda
        $mail->Password   = 'wcjzesuubhlcgxni'; // Ganti dengan password email Anda
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Set sender and recipient
        $mail->setFrom('appkejariberau@gmail.com', 'Aplikasi Tester');
        $mail->addAddress($email);

        // Set email content
        $mail->isHTML(true);
        $mail->Subject = 'Permintaan Reset Password';
        $mail->Body    = 'Anda baru saja melakukan permintaan reset password. Jika benar, silahkan klik <a href="http://localhost/tester/reset_password.php?token=' . $token . '">disini</a> untuk melakukan reset password. Jika ini bukan anda, silahkan abaikan pesan ini';

        $mail->send();
        return true;

    } catch (Exception $e) {
        return false;
    }
}

function generateToken()
{
    return bin2hex(random_bytes(50));
}