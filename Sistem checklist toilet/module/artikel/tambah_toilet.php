<?php
error_reporting(E_ALL);
include_once '../../class/database.php';

$db = new Database('host', 'username', 'password', 'db_name');

if (isset($_POST['submit'])) {
    $lokasi = $db->escapeString($_POST['lokasi']);
    $keterangan = $db->escapeString($_POST['keterangan']);



    $sql = "INSERT INTO toilet (lokasi, keterangan) ";
    $sql .= "VALUES ('{$lokasi}', '{$keterangan}')";

    $result = $db->query($sql);

    if (!$result) {
        echo "Error: " . $db->getError();
    } else {
        header('location: daftar-toilet.php');
    }
}
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
        <header>Tambah Data Toilet</header>
        <form action="#" class="form" id="myForm" method="post">
            <div class="input-box">
                <label>Lokasi</label>
                <input type="text" name="lokasi" placeholder="Masukkan Lokasi" required />
            </div>

            <div class="input-box">
                <label>Keterangan</label>
                <input type="text" name="keterangan" placeholder="Masukkan Keterangan" required />
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