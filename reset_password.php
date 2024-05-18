<?php
session_start();
if (isset($_SESSION['loggedin']) && true == $_SESSION['loggedin']) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reset Password</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    </head>

    <body>
        <div class="container">
            <div class="row justify-content-center">

                <div class="col-md-6 mt-5">
                    <div class="card">
                        <div class="card-header text-center">
                            Reset Password
                        </div>
                        <div class="card-body">
                            <?php if (isset($_SESSION['message'])): ?>
                            <div class="alert alert-<?php echo $_SESSION['alert_type']; ?>" role="alert">
                                <?php echo $_SESSION['message'];unset($_SESSION['message']);unset($_SESSION['alert_type']); ?>
                            </div>
                            <?php endif;?>
                            <form method="POST" action="./process_reset_password.php">
                                <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
                                <div class="form-group">
                                    <label for="new_password">Password Baru</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="new_password"
                                            name="new_password" placeholder="Masukkan password baru ..." required>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-outline-secondary"
                                                onclick="togglePassword('new_password')">
                                                <span class="fas fa-eye" id="new-password-toggle"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="confirm_password">Konfirmasi Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="confirm_password"
                                            name="confirm_password" placeholder="Masukkan ulang password baru ..."
                                            required>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-outline-secondary"
                                                onclick="togglePassword('confirm_password')">
                                                <span class="fas fa-eye" id="confirm-password-toggle"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success btn-block">Submit</button>
                            </form>

                            <div class="mt-5">
                                <a href="login.php" class="float-right">Klik disini untuk login !</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script>
        function togglePassword(inputId) {
            var passwordField = document.getElementById(inputId);
            var toggleIconId = inputId === 'new_password' ? 'new-password-toggle' : 'confirm-password-toggle';
            var toggleIcon = document.getElementById(toggleIconId);
            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleIcon.classList.remove("fa-eye");
                toggleIcon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                toggleIcon.classList.remove("fa-eye-slash");
                toggleIcon.classList.add("fa-eye");
            }
        }
        </script>
    </body>

</html>