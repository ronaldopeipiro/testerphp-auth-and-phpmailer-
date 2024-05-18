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
        <title>Login</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    </head>

    <body>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card mt-5">
                        <div class="card-header">Login</div>
                        <div class="card-body">
                            <?php
if (isset($_GET['error'])) {
    echo '<div class="alert alert-danger" role="alert">' . htmlspecialchars($_GET['error']) . '</div>';
}
?>
                            <form method="POST" action="process_login.php">
                                <div class="form-group">
                                    <input type="text" name="username" class="form-control" placeholder="Username"
                                        required>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="password" name="password" id="password" class="form-control"
                                            placeholder="Password" required>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-outline-secondary"
                                                onclick="togglePassword()">
                                                <span id="toggle-icon" class="fas fa-eye"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-block btn-success">Login</button>
                                <a href="forgot_password.php" class="float-right mt-2">Lupa Password?</a>
                            </form>

                            <div class="mt-5">
                                <div class="text-left justify-content-start">
                                    Belum punya akun ?
                                    <a href="register.php" class="btn btn-link">Register disini !</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
        function togglePassword() {
            var passwordField = document.getElementById("password");
            var toggleIcon = document.getElementById("toggle-icon");
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