<?php
session_start();

$title = 'Data Barang';
include_once '../class/database.php';

// Inisialisasi objek Database
$db = new Database('host', 'username', 'password', 'db_name');
$conn = $db->getConn(); // Menggunakan metode getConn untuk mendapatkan koneksi

if (isset($_POST['submit'])) {
    $user = $db->escapeString($_POST['username']);
    $password = $db->escapeString($_POST['password']);

    // Menggunakan password_verify untuk membandingkan password yang di-hash
    $sql = "SELECT * FROM users WHERE username = '{$user}'";
    $result = $db->query($sql);

    if ($result && $result->num_rows != 0) {
        $user_data = $result->fetch_array();

        if (password_verify($password, $user_data['password'])) {
            $_SESSION['isLogin'] = true;
            $_SESSION['username'] = $user_data['username'];

            header('location: artikel/index.php');
            exit();
        }
    }

    $errorMsg = "<p style=\"color:red;\">Gagal Login, silakan ulangi lagi. Error: " . $db->getConn()->error . "</p>";
}

if (isset($errorMsg)) {
    echo $errorMsg;
}

// Menutup koneksi database
$db->closeConnection();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
    <div class="container">
    
        <div class="wrap">
        <h2>Login</h2>
            <form method="post">
                <div class="input">
                    <label for="username"><i data-feather="user"></i></label>
                    <input type="text" name="username" id="username" placeholder="username" />
                </div>
                <div class="input">
                    <label for="pass"><i data-feather="lock"></i></label>
                    <input type="password" name="password" id="pass" placeholder="password"/>
                </div>
                <div class="submit">
                    <input type="submit" name="submit" value="Login" />
                </div>
            </form>
            <a href="register.php">Register</a>
        </div>
    </div>
    <!-- choose one -->
    <script>
        feather.replace();
    </script>
</body>

</html>