<?php
// Pastikan Anda sudah menyertakan file database.php atau sesuaikan koneksi database Anda
include_once '../../class/database.php';

// Inisialisasi objek Database
$db = new Database('host', 'username', 'password', 'db_name');
$conn = $db->getConn();
$q = isset($_GET['q']) ? $db->escapeString($_GET['q']) : '';



// Ambil parameter sort dari URL
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'asc';

// Query SQL untuk mengambil data dari tabel checklist dengan sorting
$sql = "SELECT * FROM checklist WHERE id LIKE '%$q%' OR tanggal LIKE '%$q%' OR toilet_id LIKE '%$q%' OR users_id LIKE '%$q%' ORDER BY tanggal $sort";
$result = $db->query($sql);


$db->closeConnection();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Checklist Toilet</title>
    <link rel="stylesheet" type="text/css" href="../../css/daftar-toilet.css">

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
                <h1>Checklist Toilet</h1>
                <form action="" method="get" class="input-group">
                    <input type="search" placeholder="Search Data..." class="input-q input" name="q"
                        value="<?php echo isset($_GET['q']) ? $_GET['q'] : ''; ?>">
                    <button type="submit" name="submit" class="btn btn-primary">
                        <i data-feather="search"></i>
                    </button>
                </form>
                <a href="tambah_checklist.php"><i data-feather="plus"></i></a>
            </section>
            <section class="table__body">
                <table>
                    <thead>
                        <tr>
                            <th> No<span class="icon-arrow">&UpArrow;</span></th>
                            <th> Kode Toilet<span class="icon-arrow">&UpArrow;</span></th>
                            <th> Tanggal<span class="icon-arrow">&UpArrow;</span></th>
                            <th> Kloset<span class="icon-arrow">&UpArrow;</span></th>
                            <th> Westafel<span class="icon-arrow">&UpArrow;</span></th>
                            <th> Lantai<span class="icon-arrow">&UpArrow;</span></th>
                            <th> Dinding<span class="icon-arrow">&UpArrow;</span></th>
                            <th> Kaca<span class="icon-arrow">&UpArrow;</span></th>
                            <th> Bau<span class="icon-arrow">&UpArrow;</span></th>
                            <th> Sabun<span class="icon-arrow">&UpArrow;</span></th>
                            <th> ID Petugas<span class="icon-arrow">&UpArrow;</span></th>
                            <th> Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            // Loop melalui data dan tampilkan dalam tabel
                            while ($row = $result->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td>' . $row['id'] . '</td>';
                                echo '<td>' . $row['toilet_id'] . '</td>';
                                echo '<td>' . $row['tanggal'] . '</td>';
                                $klosetText = ($row['kloset'] == 1) ? 'Bersih' : (($row['kloset'] == 2) ? 'Kotor' : 'Rusak');
                                echo '<td><p class = ' . $klosetText . '>' . $klosetText . '</p></td>';
                                $wastafelText = ($row['wastafel'] == 1) ? 'Bersih' : (($row['wastafel'] == 2) ? 'Kotor' : 'Rusak');
                                echo '<td><p class = ' . $wastafelText . '>' . $wastafelText . '</p></td>';
                                $lantaiText = ($row['lantai'] == 1) ? 'Bersih' : (($row['lantai'] == 2) ? 'Kotor' : 'Rusak');
                                echo '<td><p class = ' . $lantaiText . '>' . $lantaiText . '</p></td>';
                                $dindingText = ($row['dinding'] == 1) ? 'Bersih' : (($row['dinding'] == 2) ? 'Kotor' : 'Rusak');
                                echo '<td><p class = ' . $dindingText . '>' . $dindingText . '</p></td>';
                                $kacaText = ($row['kaca'] == 1) ? 'Bersih' : (($row['kaca'] == 2) ? 'Kotor' : 'Rusak');
                                echo '<td><p class = ' . $kacaText . '>' . $kacaText . '</p></td>';
                                $bauText = ($row['bau'] == 1) ? 'Iya' : 'Tidak';
                                echo '<td><p class = ' . $bauText . '>' . $bauText . '</p></td>';
                                $sabunText = ($row['sabun'] == 1) ? 'Ada' : (($row['sabun'] == 2) ? 'Habis' : 'Hilang');
                                echo '<td><p class = ' . $sabunText . '>' . $sabunText . '</p></td>';
                                echo '<td>' . $row['users_id'] . '</td>';
                                echo '<td>';
                                echo '<button class="btn-ubah" type="button"><a href="ubah_checklist.php?id=' . $row['id'] . '">Ubah</a></button>';
                                echo '<button class="btn-hapus" type="button"><a href="hapus_checklist.php?id=' . $row['id'] . '">Hapus</a></button>';
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