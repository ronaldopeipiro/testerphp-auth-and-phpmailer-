<?php
session_start();
require 'db.php'; // Pastikan file db.php berisi koneksi ke database

if ("POST" == $_SERVER["REQUEST_METHOD"]) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql  = "SELECT * FROM users WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if (1 == $result->num_rows) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['loggedin']         = true;
            $_SESSION['user_id_loggedin'] = $user['id'];

            // Redirect to dashboard
            header("Location: index.php");
            exit;
        } else {
            // Invalid password
            $error_message = "Username / Password Salah";
            header("Location: login.php?error=" . urlencode($error_message));
            exit;
        }
    } else {
        // No user found with that username
        $error_message = "Username / Password Salah";
        header("Location: login.php?error=" . urlencode($error_message));
        exit;
    }
}