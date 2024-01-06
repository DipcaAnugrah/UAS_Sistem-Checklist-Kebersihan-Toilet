<?php
// Pastikan Anda sudah menyertakan file database.php atau sesuaikan koneksi database Anda
include_once '../../class/database.php';

// Inisialisasi objek Database
$db = new Database('host', 'username', 'password', 'db_name');
$conn = $db->getConn();
$q = isset($_GET['q']) ? $db->escapeString($_GET['q']) : '';
$sql = "SELECT * FROM toilet WHERE id LIKE '%$q%' OR lokasi LIKE '%$q%' OR keterangan LIKE '%$q%'";

// Query SQL untuk mengambil data dari tabel
$result = $db->query($sql);

$db->closeConnection();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daftar TOilet</title>
    <link rel="stylesheet" type="text/css" href="../../css/daftar-toilet.css">
    <link rel="stylesheet" type="text/css" href="../../css/footer.css">
    <link rel="stylesheet" type="text/css" href="../../css/header.css">
    <!-- Feather icons -->
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
</head>

<body>
    <?php
    include("../../template/header.php")
        ?>
    <div class="container">
        <main class="table" id="customers_table">
            <section class="table__header">
                <h1>Daftar Toilet</h1>
                <form action="" method="get" class="input-group">
                    <input type="search" placeholder="Search Data..." class="input-q input" name="q"
                        value="<?php echo isset($_GET['q']) ? $_GET['q'] : ''; ?>">
                    <button type="submit" name="submit" class="btn btn-primary">
                        <i data-feather="search"></i>
                    </button>
                </form>

                <a href="tambah_toilet.php"><i data-feather="plus"></i></a>
            </section>
            <section class="table__body">
                <table>
                    <thead>
                        <tr>
                            <th id="col1"> No<span class="icon-arrow">&UpArrow;</span></th>
                            <th id="col2"> Lokasi<span class="icon-arrow">&UpArrow;</span></th>
                            <th id="col3"> Keterangan<span class="icon-arrow">&UpArrow;</span></th>
                            <th id="col4"> Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            // Loop melalui data dan tampilkan dalam tabel
                            while ($row = $result->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td>' . $row['id'] . '</td>';
                                echo '<td>' . $row['lokasi'] . '</td>';
                                echo '<td>' . $row['keterangan'] . '</td>';
                                echo '<td>';
                                echo '<button class="btn-ubah" type="button"><a href="ubah_toilet.php?id=' . $row['id'] . '">Ubah</a></button>';
                                echo '<button class="btn-hapus" type="button"><a href="hapus_toilet.php?id=' . $row['id'] . '">Hapus</a></button>';
                                echo '</td>';
                                echo '</tr>';
                            }
                        } else {
                            // Jika tidak ada data
                            echo '<tr><td colspan="11">Tidak ada data</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
    <?php
    include("../../template/footer.php")
        ?>
    <script src="../../js/script.js"></script>
    <!-- feather icon -->
    <script>
        feather.replace()
    </script>
    <!-- my javascript -->
    <script src="../../js/index.js"></script>

</body>

</html>