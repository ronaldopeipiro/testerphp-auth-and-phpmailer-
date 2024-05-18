<?php
session_start();
require 'db.php';

if ("POST" == $_SERVER["REQUEST_METHOD"]) {
    $token        = $_POST['token'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    $sql  = "SELECT * FROM users WHERE reset_token=? AND reset_token_expiration > NOW()";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if (1 == $result->num_rows) {
        $sql  = "UPDATE users SET password=?, reset_token=NULL, reset_token_expiration=NULL WHERE reset_token=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $new_password, $token);
        $stmt->execute();

        $_SESSION['message']    = "Your password has been updated.";
        $_SESSION['alert_type'] = "success";
    } else {
        $_SESSION['message']    = "Invalid or expired token.";
        $_SESSION['alert_type'] = "danger";
    }

    header("Location: reset_password.php?token=" . $token);
    exit;
}