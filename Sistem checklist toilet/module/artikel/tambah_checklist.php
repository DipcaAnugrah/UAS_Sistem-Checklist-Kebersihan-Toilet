<?php
error_reporting(E_ALL);
include_once '../../class/database.php';

$db = new Database('host', 'username', 'password', 'db_name');
$conn = $db->getConn();
$errors = [];

if (isset($_POST['submit'])) {
    $tanggal = $db->escapeString($_POST['tanggal']);
    $toilet_id = $db->escapeString($_POST['toilet_id']);
    $kloset = $db->escapeString($_POST['kloset']);
    $wastafel = $db->escapeString($_POST['wastafel']);
    $lantai = $db->escapeString($_POST['lantai']);
    $dinding = $db->escapeString($_POST['dinding']);
    $kaca = $db->escapeString($_POST['kaca']);
    $bau = $db->escapeString($_POST['bau']);
    $sabun = $db->escapeString($_POST['sabun']);
    $users_id = $db->escapeString($_POST['users_id']);

    if (empty($tanggal) || empty($kloset) || empty($wastafel) || empty($lantai) || empty($dinding) || empty($kaca) || empty($bau) || empty($sabun) || empty($users_id)) {
        $errors[] = "Semua field harus diisi";
    }

    // Pemeriksaan apakah ID petugas ada di tabel users
    $sqlCheckUser = "SELECT * FROM users WHERE id = '{$users_id}'";
    $resultCheckUser = $db->query($sqlCheckUser);

    if ($resultCheckUser->num_rows == 0) {
        $errors[] = "ID Petugas tidak valid. Pilih ID petugas yang benar.";
    }

    // Pemeriksaan apakah ID toilet ada di tabel toilet
    $sqlCheckToilet = "SELECT * FROM toilet WHERE id = '{$toilet_id}'";
    $resultCheckToilet = $db->query($sqlCheckToilet);
    
    if ($resultCheckToilet->num_rows == 0) {
        $errors[] = "Kode Toilet tidak valid. Pilih ID Toilet yang benar.";
    }

    if (empty($errors)) {
        $sql = "INSERT INTO checklist (tanggal, toilet_id, kloset, wastafel, lantai, dinding, kaca, bau, sabun, users_id) ";
        $sql .= "VALUES ('{$tanggal}', '{$toilet_id}', '{$kloset}', '{$wastafel}', '{$lantai}', '{$dinding}', '{$kaca}', '{$bau}', '{$sabun}', '{$users_id}')";

        $result = $db->query($sql);

        if (!$result) {
            echo "Error: " . $db->getError();
        } else {
            header('location: checklist-toilet.php');
            exit(); // Pastikan untuk keluar dari script setelah melakukan redirect
        }
    }
}



// Query SQL untuk mendapatkan data kode toilet dan nama toilet dari tabel toilet
$sqlToilet = "SELECT * FROM toilet";
$resultToilet = $db->query($sqlToilet);

// Periksa apakah ada data toilet
if ($resultToilet->num_rows > 0) {
    $toiletOptions = '';
    // Loop melalui data toilet dan buat opsi untuk elemen select
    while ($rowToilet = $resultToilet->fetch_assoc()) {
        $toiletOptions .= '<option value="' . $rowToilet['id'] . '">' . $rowToilet['lokasi'] . ' - ' . $rowToilet['keterangan'] . '</option>';
    }
} else {
    // Jika tidak ada data toilet
    $toiletOptions = '<option value="" disabled selected>Tidak ada data toilet</option>';
}
// Query SQL untuk mendapatkan data users dari tabel users
$sqlUsers = "SELECT * FROM users";
$resultUsers = $db->query($sqlUsers);
// Periksa apakah ada data toilet
if ($resultUsers->num_rows > 0) {
    $usersOptions = '';
    // Loop melalui data toilet dan buat opsi untuk elemen select
    while ($rowUsers = $resultUsers->fetch_assoc()) {
        $usersOptions .= '<option value="' . $rowUsers['id'] . '">'. $rowUsers['id'] . ' - ' . $rowUsers['username'] . '</option>';
    }
} else {
    // Jika tidak ada data toilet
    $usersOptions = '<option value="" disabled selected>Tidak ada data toilet</option>';
}

// Menutup koneksi database
$db->closeConnection();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <!--<title>Registration Form in HTML CSS</title>-->
    <!---Custom CSS File--->
    <link rel="stylesheet" href="../../css/tambah.css" />
</head>

<body>
    <section class="container">
        <header>Tambah Data Checklist</header>
        <?php
        // Tampilkan pesan kesalahan jika ada
        if (!empty($errors)) {
            echo '<div class="error-container">';
            foreach ($errors as $error) {
                echo '<p class="error-message" style="font-size:12px; color:#ee6e6e;">' . $error . '</p>';
            }
            echo '</div>';
        }
        ?>
        <form action="#" class="form" id="myForm" method="post">
            <div class="column">
                <div class="input-box">
                    <label>Kode Toilet</label>
                    <div class="select-box">
                        <select name="toilet_id" id="toilet_id" required>
                            <option value="kosong" hidden>Enter Toilet</option>
                            <?php echo $toiletOptions; ?>
                        </select>
                    </div>
                </div>
                <div class="input-box">
                    <label>Tanggal</label>
                    <input type="date" placeholder="Enter date" name="tanggal" required />
                </div>
            </div>
            <div class="column">
                <div class="input-box">
                <label>ID Petugas</label>
                    <div class="select-box">
                        <select name="users_id" id="users_id" required>
                            <option hidden>Enter Petugas</option>
                            <?php echo $usersOptions; ?>
                        </select>
                    </div>
                </div>
                <div class="input-box">
                <label>Kloset</label>
                    <div class="select-box">
                        <select name="kloset" id="kloset" required>
                            <option hidden>Keadaan</option>
                            <option value="1">Bersih</option>
                            <option value="2">Kotor</option>
                            <option value="3">Rusak</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="column">
            <div class="input-box">
                <label for="wastafel" >Wastafel</label>
                    <div class="select-box">
                        <select name="wastafel" id="wastafel" required>
                            <option hidden>Keadaan</option>
                            <option value="1">Bersih</option>
                            <option value="2">Kotor</option>
                            <option value="3">Rusak</option>
                        </select>
                    </div>
                </div>
                <div class="input-box">
                <label>Lantai</label>
                    <div class="select-box">
                        <select name="lantai" id="lantai" required>
                            <option hidden>Keadaan</option>
                            <option value="1">Bersih</option>
                            <option value="2">Kotor</option>
                            <option value="3">Rusak</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="input-box">
                <label>Dinding</label>
                    <div class="select-box">
                        <select name="dinding" id="dinding" required>
                            <option hidden>Keadaan</option>
                            <option value="1">Bersih</option>
                            <option value="2">Kotor</option>
                            <option value="3">Rusak</option>
                        </select>
                    </div>
                </div>
                <div class="input-box">
                <label>Kaca</label>
                    <div class="select-box">
                        <select name="kaca" id="kaca" required>
                            <option hidden>Keadaan</option>
                            <option value="1">Bersih</option>
                            <option value="2">Kotor</option>
                            <option value="3">Rusak</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="column">
            <div class="input-box">
                <label>Bau</label>
                    <div class="select-box">
                        <select name="bau" id="bau" required>
                            <option hidden>Bau</option>
                            <option value="1">Iya</option>
                            <option value="2">Tidak</option>
                        </select>
                    </div>
                </div>
                <div class="input-box">
                <label>Sabun</label>
                    <div class="select-box">
                        <select name="sabun" id="sabun" required>
                            <option hidden>Kondisi</option>
                            <option value="1">Ada</option>
                            <option value="2">Habis</option>
                            <option value="3">Hilang</option>
                        </select>
                    </div>
                </div>
            </div>
            <button type="reset" onClick="closeForm()" class="batal">Batal</button>
            <button type="submit" name="submit" class="submit">Simpan</button>
        </form>
    </section>
    <script>
        function closeForm() {
            // Menggunakan JavaScript untuk menutup formulir dan kembali ke halaman utama
            document.getElementById("myForm").style.display = "none";
            window.location.href = "checklist-toilet.php";
        }
    </script>
</body>

</html>

</html>