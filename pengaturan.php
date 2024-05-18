<?php
session_start();
if (!isset($_SESSION['loggedin']) || true !== $_SESSION['loggedin']) {
    header("Location: login.php");
    exit;
}

require 'db.php';

$user_id       = $_SESSION['user_id_loggedin'];
$message       = '';
$class_warning = 'danger';

if ("POST" == $_SERVER["REQUEST_METHOD"]) {
    if (isset($_POST['update_profile'])) {
        $username = $_POST['username'];
        $email    = $_POST['email'];

        $sql  = "UPDATE users SET username=?, email=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $username, $email, $user_id);
        if ($stmt->execute()) {
            $_SESSION['username'] = $username;
            $message              = "Profil berhasil diperbarui.";
        } else {
            $message = "Gagal memperbarui profil.";
        }
    } elseif (isset($_POST['update_password'])) {
        $current_password = $_POST['current_password'];
        $new_password     = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        $sql  = "SELECT password FROM users WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        if (password_verify($current_password, $hashed_password)) {
            if ($new_password == $confirm_password) {
                $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);

                $sql  = "UPDATE users SET password=? WHERE id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("si", $new_password_hashed, $user_id);
                if ($stmt->execute()) {
                    $message       = "Password berhasil diperbarui ";
                    $class_warning = 'success';
                } else {
                    $message = "Gagal memperbarui password.";
                }
            } else {
                $message = "Password baru dan konfirmasi password tidak cocok.";
            }
        } else {
            $message = "Password saat ini salah.";
        }
    }
}

$sql  = "SELECT username, email FROM users WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user   = $result->fetch_assoc();
?>


<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Pengaturan</title>
        <!-- Bootstrap CSS -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom CSS for sidebar -->
        <style>
        body {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        .sidebar {
            width: 250px;
            background-color: #343a40;
            color: white;
            height: 100%;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            padding: 1rem;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
        }

        .sidebar a:hover {
            background-color: #495057;
            text-decoration: none;
        }

        .content {
            margin-left: 250px;
            padding: 1rem;
            width: 100%;
        }
        </style>
    </head>

    <body>
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>Dashboard</h2>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="./">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./pengaturan.php">Pengaturan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="confirmLogout()">Logout</a>
                </li>
            </ul>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <h1 class="mt-4">Pengaturan</h1>
                        <hr>
                    </div>
                </div>

                <div class="row justify-content-start">

                    <div class="col-12">
                        <?php if ($message): ?>
                        <div class="alert alert-<?=$class_warning?>" role="alert">
                            <?=$message;?>
                        </div>
                        <?php endif;?>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">Ubah Profil</div>
                            <div class="card-body">

                                <form method="POST" action="">
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" id="username" name="username"
                                            value="<?=$user['username'];?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="<?=$user['email'];?>" required>
                                    </div>
                                    <button type="submit" name="update_profile" class="btn btn-success btn-block">
                                        Simpan
                                    </button>
                                </form>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">Ubah Password</div>
                            <div class="card-body">

                                <form method="POST" action="">
                                    <div class="form-group">
                                        <label for="current_password">Password Saat Ini</label>
                                        <input type="password" class="form-control" id="current_password"
                                            name="current_password" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="new_password">Password Baru</label>
                                        <input type="password" class="form-control" id="new_password"
                                            name="new_password" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="confirm_password">Konfirmasi Password Baru</label>
                                        <input type="password" class="form-control" id="confirm_password"
                                            name="confirm_password" required>
                                    </div>
                                    <button type="submit" name="update_password" class="btn btn-success btn-block">
                                        Simpan
                                    </button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap JS and dependencies -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <!-- JavaScript for logout confirmation -->
        <script>
        function confirmLogout() {
            if (confirm("Apakah anda yakin ingin keluar ?")) {
                window.location.href = "logout.php";
            }
        }
        </script>
    </body>

</html>