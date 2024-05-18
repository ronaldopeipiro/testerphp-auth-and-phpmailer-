<?php
session_start();
if (isset($_SESSION['loggedin']) && true == $_SESSION['loggedin']) {
    header("Location: index.php");
    exit;
}

require 'db.php';

if ("POST" == $_SERVER["REQUEST_METHOD"]) {
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $aktif    = 'Y'; // Set nilai default untuk kolom aktif

    // Prepared statement untuk memeriksa apakah username sudah digunakan sebelumnya
    $sql_check_username  = "SELECT COUNT(*) AS count FROM users WHERE username = ?";
    $stmt_check_username = $conn->prepare($sql_check_username);
    $stmt_check_username->bind_param("s", $username);
    $stmt_check_username->execute();
    $result_check_username = $stmt_check_username->get_result();
    $row_username          = $result_check_username->fetch_assoc();

    if ($row_username['count'] > 0) {
        $error_message = "Username sudah digunakan!";
        header("Location: register.php?error=" . urlencode($error_message));
        exit;
    }

    // Prepared statement untuk memeriksa apakah email sudah digunakan sebelumnya
    $sql_check_email  = "SELECT COUNT(*) AS count FROM users WHERE email = ?";
    $stmt_check_email = $conn->prepare($sql_check_email);
    $stmt_check_email->bind_param("s", $email);
    $stmt_check_email->execute();
    $result_check_email = $stmt_check_email->get_result();
    $row_email          = $result_check_email->fetch_assoc();

    if ($row_email['count'] > 0) {
        $error_message = "Email sudah digunakan!";
        header("Location: register.php?error=" . urlencode($error_message));
        exit;
    }

    // Prepared statement untuk mencegah SQL Injection
    $sql_insert  = "INSERT INTO users (username, email, password, create_datetime, aktif) VALUES (?, ?, ?, NOW(), ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("ssss", $username, $email, $password, $aktif);

    if ($stmt_insert->execute()) {
        $success_message = "Registrasi berhasil ! silahkan login dengan akun baru anda !";
        header("Location: register.php?success=" . urlencode($success_message));
        exit;
    } else {
        $error_message = "Registrasi gagal : " . $stmt_insert->error;
        header("Location: register.php?error=" . urlencode($error_message));
        exit;
    }
}