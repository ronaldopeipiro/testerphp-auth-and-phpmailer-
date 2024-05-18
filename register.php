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
        <title>Register</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    </head>

    <body>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card mt-5">
                        <div class="card-header">Register</div>
                        <div class="card-body">
                            <?php
if (isset($_GET['error'])) {
    echo '<div class="alert alert-danger" role="alert">' . htmlspecialchars($_GET['error']) . '</div>';
} elseif (isset($_GET['success'])) {
    echo '<div class="alert alert-success" role="alert">' . htmlspecialchars($_GET['success']) . '</div>';
}
?>
                            <form method="POST" action="process_register.php">
                                <div class="form-group">
                                    <input type="text" name="username" class="form-control" placeholder="Username"
                                        required>
                                </div>
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control" placeholder="Password"
                                        required>
                                </div>
                                <button type="submit" class="btn btn-success btn-block">Register</button>
                            </form>

                            <div class="mt-5">
                                <a href="login.php" class="float-right">Sudah punya akun ? Login disini !</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>

</html>