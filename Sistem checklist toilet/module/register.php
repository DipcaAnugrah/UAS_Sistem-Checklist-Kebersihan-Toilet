<?php
// Pastikan Anda sudah menyertakan file database.php atau sesuaikan koneksi database Anda
include_once '../class/database.php';

// Inisialisasi objek Database
$db = new Database('host', 'username', 'password', 'db_name');
$conn = $db->getConn();

// Inisialisasi variabel error
$errors = [];

// Proses registrasi jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari formulir
    $username = $db->escapeString($_POST['username']);
    $fullname = $db->escapeString($_POST['full-name']);
    $password = $db->escapeString($_POST['password']);
    $confirm_password = $db->escapeString($_POST['repass']);
    $email = $db->escapeString($_POST['email']);
    $status = $db->escapeString($_POST['status']);
    $role = $db->escapeString($_POST['role']);

    // Validasi formulir
    if (empty($username)) {
        $errors[] = "Username tidak boleh kosong";
    }
    if (empty($fullname)) {
        $errors[] = "Full name tidak boleh kosong";
    }

    if (empty($password)) {
        $errors[] = "Password tidak boleh kosong";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Konfirmasi password tidak sesuai";
    }
    if (empty($email)) {
        $errors[] = "Email tidak boleh kosong";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format email tidak valid";
    }
    if (empty($status)) {
        $errors[] = "Status tidak boleh kosong";
    }
    if (empty($role)) {
        $errors[] = "Role tidak boleh kosong";
    }
    // Jika tidak ada error, lakukan proses registrasi
    if (empty($errors)) {
        // Hash password sebelum menyimpan ke database
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Query untuk menyimpan data ke database
        $sql = "INSERT INTO users (username, password, email, nama, status, role) VALUES ('{$username}', '{$hashed_password}', '{$email}', '{$fullname}', '{$status}', '{$role}')";

        if ($db->query($sql)) {
            // Registrasi berhasil, mungkin akan diarahkan ke halaman login
            header('Location: login.php');
            exit();
        } else {
            $errors[] = "Gagal menyimpan data ke database. Error: " . $db->getConn()->error;
        }
    }
}

// Menutup koneksi database
$db->closeConnection();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../css/login.css">
    <!-- font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,300;0,400;1,200;1,300;1,400&family=Rubik+Maps&family=Source+Sans+3:wght@400;500;600&display=swap"
        rel="stylesheet">
    <!-- feather icon -->
    <!-- choose one -->
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

</head>

<body>

    <?php
    // Tampilkan pesan error jika ada
    if (!empty($errors)) {
        echo '<div style="color: red;">';
        foreach ($errors as $error) {
            echo $error . '<br>';
        }
        echo '</div>';
    }
    ?>

    <div class="container">

        <div class="wrap">
            <h2>Register</h2>
            <form method="post">
                <div class="input">
                    <label for="username"><i data-feather="user"></i></label>
                    <input type="text" name="username" id="username" placeholder="username" required />
                </div>
                <div class="input">
                    <label for="full-name"><i data-feather="users"></i></label>
                    <input type="text" name="full-name" id="full-name" placeholder="full name" required />
                </div>
                <div class="input">
                    <label for="email"><i data-feather="mail"></i></label>
                    <input type="text" name="email" id="email" placeholder="email" required />
                </div>
                <div class="input">
                    <label for="pass"><i data-feather="unlock"></i></label>
                    <input type="password" name="password" id="pass" placeholder="password" required />
                </div>
                <div class="input">
                    <label for="repass"><i data-feather="lock"></i></label>
                    <input type="password" name="repass" id="repass" placeholder="confirm password" required />
                </div>
                <div class="input-select">
                    <label for="status">Status:</label>
                    <select name="status" id="status" required>
                        <option hidden>Status</option>
                        <option value="1">Aktif</option>
                        <option value="2">Non-aktif</option>
                    </select>
                </div>
                <div class="input-select">
                    <label for="role">Role:</label>
                    <select name="role" id="role" required>
                        <option hidden>Role</option>
                        <option value="1">Admin</option>
                        <option value="2">User</option>
                    </select>
                </div>
                <div class="submit">
                    <input type="submit" name="submit" value="Sign Up" />
                </div>

            </form>
            <a href="login.php">Login</a>
        </div>
    </div>
    <!-- choose one -->
    <script>
        feather.replace();
    </script>
</body>

</html>