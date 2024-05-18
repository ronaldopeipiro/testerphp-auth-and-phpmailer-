<?php
session_start();
if (isset($_SESSION['loggedin']) && true == $_SESSION['loggedin']) {
    header("Location: index.php");
    exit;
}

require 'db.php';
require 'functions.php';

$message = ''; // Inisialisasi variabel pesan

if ("POST" === $_SERVER["REQUEST_METHOD"]) {
    $email = $_POST['email'];

    $sql  = "SELECT * FROM users WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if (1 === $result->num_rows) {
        $token = generateToken();

        // Set timezone to Asia/Jakarta
        date_default_timezone_set('Asia/Jakarta');
        $expires_at = date("Y-m-d H:i:s", strtotime('+1 hour'));

        $sql  = "UPDATE users SET reset_token=?, reset_token_expiration=? WHERE email=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $token, $expires_at, $email);
        $stmt->execute();

        if (sendPasswordReset($email, $token)) {
            $message = "Berhasil! Silahkan periksa email anda untuk melakukan reset password.";
        } else {
            $message = "Gagal mengirim email reset password. Periksa email anda!";
        }
    } else {
        $message = "Email tidak valid!";
    }
}
?>

<!DOCTYPE html>
<html>

    <head>
        <title>Forgot Password</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    </head>

    <body>
        <div class="container">
            <div class="row justify-content-center mt-5">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Forgot Password</div>
                        <div class="card-body">
                            <?php if (!empty($message)): ?>
                            <div class="alert <?php echo (strpos($message, 'Gagal') !== false || strpos($message, 'tidak valid') !== false) ? 'alert-danger' : 'alert-success'; ?>"
                                role="alert">
                                <?php echo $message; ?>
                            </div>
                            <?php endif;?>
                            <form method="POST" action="">
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control"
                                        placeholder="Masukkan email ..." required>
                                </div>
                                <button type="submit" class="btn btn-success btn-block">Reset Password</button>
                            </form>

                            <div class="mt-5">
                                <a href="login.php" class="float-right">Klik disini untuk login !</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

</html>