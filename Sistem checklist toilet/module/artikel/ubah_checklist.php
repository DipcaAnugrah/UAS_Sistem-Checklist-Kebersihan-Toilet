<?php
// Pastikan Anda sudah menyertakan file database.php atau sesuaikan koneksi database Anda
include_once '../../class/database.php';

// Inisialisasi objek Database
$db = new Database('host', 'username', 'password', 'db_name');
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

    // ... (other form data)

    // Build your SQL statement based on the form data
    $sql = "UPDATE checklist SET tanggal='{$tanggal}', toilet_id='{$toilet_id}', kloset='{$kloset}', wastafel='{$wastafel}', lantai='{$lantai}', dinding='{$dinding}', kaca='{$kaca}', bau='{$bau}', sabun='{$sabun}', users_id='{$users_id}' WHERE id='{$id}'";


    $result = $db->query($sql);

    if (!$result) {
        die('Error: ' . $db->getError());
    } else {
        header('location: checklist-toilet.php');
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
        $usersOptions .= '<option value="' . $rowUsers['id'] . '">' . $rowUsers['id'] . ' - ' . $rowUsers['username'] . '</option>';
    }
} else {
    // Jika tidak ada data toilet
    $usersOptions = '<option value="" disabled selected>Tidak ada data toilet</option>';
}
$id = $_GET['id'];
$sql = "SELECT * FROM checklist WHERE id = '{$id}'";
$result = $db->query($sql);
if (!$result) {
    die('Error: Data tidak tersedia');
}
$data = mysqli_fetch_array($result);

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
        <header>Ubah Data Checklist</header>
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
                            <option hidden>
                                <?php echo $data['toilet_id']; ?>
                            </option>
                            <?php echo $toiletOptions; ?>
                        </select>
                    </div>
                </div>
                <div class="input-box">
                    <label>Tanggal</label>
                    <input type="date" value="<?php echo date('Y-m-d', strtotime($data['tanggal'])); ?>" name="tanggal"
                        required />
                </div>
            </div>
            <div class="column">
                <div class="input-box">
                    <label>ID Petugas</label>
                    <div class="select-box">
                        <select name="users_id" id="users_id" required>
                            <option hidden>
                                <?php echo $data['users_id'] ?>
                            </option>
                            <?php echo $usersOptions; ?>
                        </select>
                    </div>
                </div>
                <div class="input-box">
                    <label>Kloset</label>
                    <div class="select-box">
                        <select name="kloset" id="kloset" required>
                            <?php
                            $klosetText = ($row['kloset'] == 1) ? 'Bersih' : (($row['kloset'] == 2) ? 'Kotor' : 'Rusak');
                            ?>
                            <option value="<?php echo $data['kloset']; ?>" hidden>
                                <?php echo $klosetText; ?>
                            </option>
                            <option value="1">Bersih</option>
                            <option value="2">Kotor</option>
                            <option value="3">Rusak</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="input-box">
                    <label for="wastafel">Wastafel</label>
                    <div class="select-box">
                        <select name="wastafel" id="wastafel" required>
                            <?php
                            $wastafelText = ($row['wastafel'] == 1) ? 'Bersih' : (($row['wastafel'] == 2) ? 'Kotor' : 'Rusak');
                            ?>
                            <option value="<?php echo $data['wastafel']; ?>" hidden>
                                <?php echo $wastafelText; ?>
                            </option>
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
                            <?php
                            $lantaiText = ($row['lantai'] == 1) ? 'Bersih' : (($row['lantai'] == 2) ? 'Kotor' : 'Rusak');
                            ?>
                            <option value="<?php echo $data['lantai']; ?>" hidden>
                                <?php echo $lantaiText; ?>
                            </option>
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
                            <?php
                            $dindingText = ($row['dinding'] == 1) ? 'Bersih' : (($row['dinding'] == 2) ? 'Kotor' : 'Rusak');
                            ?>
                            <option value="<?php echo $data['dinding']; ?>" hidden>
                                <?php echo $dindingText; ?>
                            </option>
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
                            <?php
                            $kacaText = ($row['kaca'] == 1) ? 'Bersih' : (($row['kaca'] == 2) ? 'Kotor' : 'Rusak');
                            ?>
                            <option value="<?php echo $data['kaca']; ?>" hidden>
                                <?php echo $kacaText; ?>
                            </option>
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
                            <?php
                            $bauText = ($row['bau'] == 1) ? 'Iya' : 'Tidak';
                            ?>
                            <option value="<?php echo $data['bau']; ?>" hidden>
                                <?php echo $bauText; ?>
                            </option>
                            <option value="1">Iya</option>
                            <option value="2">Tidak</option>
                        </select>
                    </div>
                </div>
                <div class="input-box">
                    <label>Sabun</label>
                    <div class="select-box">
                        <select name="sabun" id="sabun" required>
                            <?php
                            $sabunText = ($row['sabun'] == 1) ? 'Ada' : (($row['sabun'] == 2) ? 'Habis' : 'Hilang');
                            ?>
                            <option value="<?php echo $data['sabun']; ?>" hidden>
                                <?php echo $sabunText; ?>
                            </option>
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