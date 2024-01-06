<?php
// Pastikan Anda sudah menyertakan file database.php atau sesuaikan koneksi database Anda
include_once '../../class/database.php';

// Inisialisasi objek Database
$db = new Database('host', 'username', 'password', 'db_name');
if (isset($_POST['submit'])) {
    $id = $db->escapeString($_POST['id']);
    $lokasi = $db->escapeString($_POST['lokasi']);
    $keterangan = $db->escapeString($_POST['keterangan']);
    // ... (other form data)

    // Build your SQL statement based on the form data
    $sql = "UPDATE toilet SET lokasi='{$lokasi}', keterangan='{$keterangan}' WHERE id='{$id}'";

    $result = $db->query($sql);

    if (!$result) {
        die('Error: ' . $db->getError());
    } else {
        header('location: daftar-toilet.php');
    }
}

$id = $_GET['id'];
$sql = "SELECT * FROM toilet WHERE id = '{$id}'";
$result = $db->query($sql);
if (!$result) {
    die('Error: Data tidak tersedia');
}
$data = mysqli_fetch_array($result);

$db->closeConnection();
?>
<!DOCTYPE html>
<!---Coding By CodingLab | www.codinglabweb.com--->
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
        <header>Ubah Data Toilet</header>
        <form action="#" class="form" id="myForm" method="post">
            <div class="input-box">
                <label>Lokasi</label>
                <input type="text" name="lokasi" placeholder="<?php echo $data['lokasi']; ?>" required/>
            </div>

            <div class="input-box">
                <label>Keterangan</label>
                <input type="text" name="keterangan" placeholder="<?php echo $data['keterangan']; ?>" required />
            </div>
            <button type="reset" onClick="closeForm()" class="batal">Batal</button>
            <button type="submit" name="submit" class="submit">Simpan</button>
        </form>
    </section>

    <script>
    function closeForm() {
        // Menggunakan JavaScript untuk menutup formulir dan kembali ke halaman utama
        document.getElementById("myForm").style.display = "none";
        window.location.href = "daftar-toilet.php";
    }
</script>
</body>

</html>