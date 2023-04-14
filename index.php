<!-- shift+alt+f-->
<!DOCTYPE html>
<html>

<head>
    <title>Familaw</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<?php
// Memanggil file a.php
include 'GETdata.php';
?>

<body style="background-color:#191a1b">
    <nav class="navbar navbar-expand-md navbar-light flex-md-column">
        <div class="container-fluid">
            <div class="navbar-brand"><img src="image/logo.png" alt=""></div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="masuk.php">Login Admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>



    <div class="container-fluid" style="padding-top:25px">
        <div class="table-responsive">

            <table class="table table-bordered" id="data-table">
                <thead>
                    <tr>
                        <th style="background-color:black; color:white">Id Klien</th>
                        <th style="background-color:black; color:white">Klasifikasi Perkara</th>
                        <th style="background-color:black; color:white">Pengadilan</th>
                        <th style="background-color:black; color:white">Tempat Pengadilan</th>
                        <th style="background-color:black; color:white">No.Perkara</th>
                        <th style="background-color:black; color:white">Tanggal</th>
                        <th style="background-color:black; color:white">Agenda</th>
                        <th style="background-color:black; color:white">Link</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Mengecek apakah ada data atau tidak
                    if (!empty($data)) {
                        // Output data dari setiap baris
                        foreach ($data as $row) {
                            echo "<tr>";
                            echo "<td style='color:white'>" . $row["id_klien"] . "</td>";
                            echo "<td style='color:white'>" . $row["klasifikasi_perkara"] . "</td>";
                            echo "<td style='color:white'>" . $row["pengadilan"] . "</td>";
                            echo "<td style='color:white'>" . $row["misili_pengadilan"] . "</td>";
                            echo "<td style='color:white'>" . $row["no_perkara"] . "</td>";
                            echo "<td style='color:white'>" . $row["tanggal"] . "</td>";
                            echo "<td style='color:white'>" . $row["agenda"] . "</td>";
                            echo "<td style='color:white'><a href=" . $row["link"] . ">Detail</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>Tidak ada data</td></tr>";
                    }
                    ?>
                </tbody>

            </table>
            <div id="pagination">
                <!-- Tombol halaman akan ditampilkan di sini -->
            </div>

        </div>

    </div>

</body>
<script>
    // Ambil elemen tabel dan elemen pagination
    const dataTable = document.querySelector('#data-table tbody');
    const pagination = document.querySelector('#pagination');

    // Definisikan variabel untuk menyimpan data dan jumlah halaman
    let data = [];
    let pageCount = 0;

    // Fungsi untuk menampilkan data di tabel
    function renderData(page) {
        // Hitung indeks data pertama dan terakhir untuk halaman saat ini
        const startIndex = (page - 1) * 10;
        const endIndex = startIndex + 10;
        const currentPageData = data.slice(startIndex, endIndex);

        // Hapus semua baris data yang ada di tabel
        while (dataTable.firstChild) {
            dataTable.removeChild(dataTable.firstChild);
        }

        // Tambahkan baris data yang sesuai ke dalam tabel
        currentPageData.forEach((item, index) => {
            const row = dataTable.insertRow(index);
            const noCell = row.insertCell(0);
            const namaCell = row.insertCell(1);
            const emailCell = row.insertCell(2);
            const alamatCell = row.insertCell(3);

            noCell.textContent = startIndex + index + 1;
            namaCell.textContent = item.nama;
            emailCell.textContent = item.email;
            alamatCell.textContent = item.alamat;
        });
    }

    // Fungsi untuk menampilkan tombol halaman di pagination
    function renderPagination() {
        // Hapus semua tombol halaman yang ada di pagination
        while (pagination.firstChild) {
            pagination.removeChild(pagination.firstChild);
        }

        // Tambahkan tombol halaman yang sesuai ke dalam pagination
        for (let i = 1; i <= pageCount; i++) {
            const button = document.createElement('button');
            button.textContent = i;
            button.addEventListener('click', () => {
                renderData(i);
            });

            pagination.appendChild(button);
        }
    }

    // Fungsi untuk memuat data dari server
    function loadData() {
        // Lakukan fetch data dari server
        fetch('GETdata.php')
            .then((response) => response.json())
            .then((result) => {
                // Simpan data ke dalam variabel dan hitung jumlah halaman
                data = result;
                pageCount = Math.ceil(data.length / 10);

                // Tampilkan data dan tombol halaman di halaman pertama
                renderData(1);
                renderPagination();
            })
            .catch((error) => console.error(error));
    }

    // Panggil fungsi loadData untuk memuat data pertama kali
    loadData();
</script>

</html>